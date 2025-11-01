<?php
/**
 * Edit Product - Dedicated Page
 */

require_once '../config/Database.php';
require_once '../config/Auth.php';
require_once '../config/FileUploader.php';

Auth::require();

$db = Database::getInstance();
$user = Auth::user();
$message = '';
$messageType = '';

// Get product ID
$productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$productId) {
    header('Location: products.php');
    exit;
}

// Fetch product data
$product = $db->fetchOne("SELECT * FROM products WHERE id = ?", [$productId]);

if (!$product) {
    header('Location: products.php');
    exit;
}

// Fetch product images
$productImages = $db->fetchAll("SELECT * FROM product_images WHERE product_id = ? ORDER BY display_order", [$productId]);

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && Auth::verifyToken($_POST['csrf_token'] ?? '')) {
    try {
        $uploader = new FileUploader('uploads/products/');
        
        // Process specifications
        $specifications = [];
        if (isset($_POST['specifications']['label']) && isset($_POST['specifications']['value'])) {
            $labels = $_POST['specifications']['label'];
            $values = $_POST['specifications']['value'];
            for ($i = 0; $i < count($labels); $i++) {
                if (!empty($labels[$i]) && !empty($values[$i])) {
                    $specifications[$labels[$i]] = $values[$i];
                }
            }
        }
        
        // Process instructions (simple text array, video URL stored separately)
        $instructions = [];
        if (!empty($_POST['instructions'])) {
            $instructions = array_filter($_POST['instructions'], function($val) {
                return !empty(trim($val));
            });
        }
        
        $features = array_filter($_POST['features'] ?? [], function($val) {
            return !empty(trim($val));
        });
        
        // Check if slug column exists and handle slug generation
        $slug = null;
        $slugColumnExists = false;
        
        try {
            // Try to query the slug column to check if it exists
            $db->query("SELECT slug FROM products LIMIT 1");
            $slugColumnExists = true;
            
            // Manual slug takes priority if provided and not empty
            if (!empty($_POST['slug_manual'])) {
                $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $_POST['slug_manual'])));
                $slug = trim($slug, '-');
            } 
            // Auto-generate from name if auto is checked or no manual slug provided
            else if (isset($_POST['slug_auto']) || empty($_POST['slug_manual'])) {
                $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $_POST['name'] ?? '')));
                $slug = trim($slug, '-');
            }
            // Keep existing slug if no changes
            else {
                $slug = $product['slug'] ?? null;
            }
            
            // Ensure slug is unique (exclude current product)
            if (!empty($slug)) {
                $baseSlug = $slug;
                $counter = 1;
                while ($db->fetchOne("SELECT id FROM products WHERE slug = ? AND id != ?", [$slug, $productId])) {
                    $slug = $baseSlug . '-' . $counter;
                    $counter++;
                }
            }
        } catch (Exception $e) {
            // Slug column doesn't exist yet, skip it
            $slugColumnExists = false;
            $slug = null;
        }
        
        // Check if instructions_video column exists
        $instructionsVideoColumnExists = false;
        try {
            $testInstructionsVideo = $product['instructions_video'] ?? null;
            $instructionsVideoColumnExists = true;
        } catch (Exception $e) {
            $instructionsVideoColumnExists = false;
        }
        
        // Prepare product data
        $productData = [
            'name' => $_POST['name'] ?? '',
            'subtitle' => $_POST['subtitle'] ?? '',
            'description' => $_POST['description'] ?? '',
            'details' => $_POST['details'] ?? '',
            'price_min' => !empty($_POST['price_min']) ? (float)$_POST['price_min'] : null,
            'price_max' => !empty($_POST['price_max']) ? (float)$_POST['price_max'] : null,
            'price_unit' => $_POST['price_unit'] ?? '',
            'badge' => $_POST['badge'] ?? '',
            'video_url' => $_POST['video_url'] ?? '',
            'instructions' => json_encode(array_values($instructions)),
            'features' => json_encode(array_values($features)),
            'specifications' => json_encode($specifications),
            'meta_title' => $_POST['meta_title'] ?? '',
            'meta_description' => $_POST['meta_description'] ?? '',
            'meta_keywords' => $_POST['meta_keywords'] ?? '',
            'status' => $_POST['status'] ?? 'active'
        ];
        
        // Add slug only if column exists and slug was generated
        if ($slugColumnExists && $slug !== null) {
            $productData['slug'] = $slug;
        }
        
        // Add instructions_video only if column exists
        if ($instructionsVideoColumnExists) {
            $productData['instructions_video'] = $_POST['instructions_video'] ?? '';
        }
        
        // Upload new main image (if provided)
        if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] === UPLOAD_ERR_OK) {
            // Delete old image
            if ($product['main_image']) {
                $uploader->delete($product['main_image']);
            }
            
            $result = $uploader->upload($_FILES['main_image']);
            if (!isset($result['error'])) {
                $productData['main_image'] = $result;
            }
        }
        
        // Update product
        $db->update('products', $productData, 'id = :id', ['id' => $productId]);
        
        // Handle new parallax image upload (single image)
        if (isset($_FILES['parallax_image']) && $_FILES['parallax_image']['error'] === UPLOAD_ERR_OK) {
            // Delete old parallax image first
            $oldParallax = $db->fetchOne("SELECT * FROM product_images WHERE product_id = ? AND image_type = 'parallax'", [$productId]);
            if ($oldParallax) {
                $uploader->delete($oldParallax['image_path']);
                $db->delete('product_images', 'id = ?', [$oldParallax['id']]);
            }
            
            // Upload new parallax image
            $result = $uploader->upload($_FILES['parallax_image']);
            if (!is_array($result) || !isset($result['error'])) {
                // $result is the path string directly
                $imagePath = is_array($result) && isset($result['path']) ? $result['path'] : $result;
                $db->insert('product_images', [
                    'product_id' => $productId,
                    'image_path' => $imagePath,
                    'image_type' => 'parallax',
                    'display_order' => 0
                ]);
            }
        }
        
        // Handle parallax image deletion
        if (isset($_POST['delete_parallax'])) {
            $image = $db->fetchOne("SELECT * FROM product_images WHERE id = ?", [(int)$_POST['delete_parallax']]);
            if ($image) {
                $uploader->delete($image['image_path']);
                $db->delete('product_images', 'id = ?', [(int)$_POST['delete_parallax']]);
            }
        }
        
        $message = 'Product updated successfully!';
        $messageType = 'success';
        
        // Reload product data
        $product = $db->fetchOne("SELECT * FROM products WHERE id = ?", [$productId]);
        $productImages = $db->fetchAll("SELECT * FROM product_images WHERE product_id = ? ORDER BY display_order", [$productId]);
        
    } catch (Exception $e) {
        $message = 'Error updating product: ' . $e->getMessage();
        $messageType = 'danger';
    }
}

// Parse JSON fields
$instructions = json_decode($product['instructions'] ?? '[]', true) ?: [];
$features = json_decode($product['features'] ?? '[]', true) ?: [];
$specifications = json_decode($product['specifications'] ?? '[]', true) ?: [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - ZEGNEN Admin</title>
    <link rel="icon" type="image/png" href="../assets/images/zic_fav.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/admin.css">
    <!-- CKEditor 5 - Free Rich Text Editor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>
    
    <div class="main-content">
        <?php include 'includes/header.php'; ?>
        
        <div class="content-wrapper">
            <div class="page-header">
                <div>
                    <a href="products.php" class="btn btn-outline-secondary mb-2">
                        <i class="bi bi-arrow-left"></i> Back to Products
                    </a>
                    <h1 class="page-title">
                        <i class="bi bi-pencil"></i> Edit Product
                    </h1>
                    <p class="text-muted">Editing: <strong><?php echo htmlspecialchars($product['name']); ?></strong></p>
                </div>
            </div>
            
            <?php if ($message): ?>
            <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show">
                <?php echo htmlspecialchars($message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>
            
            <form method="POST" enctype="multipart/form-data" id="productForm">
                <input type="hidden" name="csrf_token" value="<?php echo Auth::generateToken(); ?>">
                
                <!-- Basic Information -->
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0"><i class="bi bi-info-circle"></i> Basic Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Product Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="productName" class="form-control" required 
                                       value="<?php echo htmlspecialchars($product['name']); ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Subtitle</label>
                                <input type="text" name="subtitle" class="form-control" 
                                       value="<?php echo htmlspecialchars($product['subtitle']); ?>">
                            </div>
                            
                            <!-- Slug Field (SEO-friendly URL) -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">URL Slug (SEO-friendly)</label>
                                <div class="input-group mb-2">
                                    <span class="input-group-text">/product/</span>
                                    <input type="text" name="slug_manual" id="slugManual" class="form-control" 
                                           placeholder="auto-generated-from-title"
                                           value="<?php echo htmlspecialchars($product['slug'] ?? ''); ?>">
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="slug_auto" id="slugAuto" checked>
                                    <label class="form-check-label" for="slugAuto">
                                        Auto-generate from product name
                                    </label>
                                </div>
                                <small class="text-muted">Leave blank and check auto-generate, or manually enter a custom URL slug</small>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Status</label>
                                <select name="status" class="form-select">
                                    <option value="active" <?php echo $product['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                                    <option value="inactive" <?php echo $product['status'] == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Short Description</label>
                                <textarea name="description" class="form-control" rows="3"><?php echo htmlspecialchars($product['description']); ?></textarea>
                                <small class="text-muted">Plain text only. Shown on product listing cards.</small>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Detailed Description <span class="text-danger">*</span></label>
                                <textarea name="details" id="detailsEditor" class="form-control" rows="10"><?php echo htmlspecialchars($product['details']); ?></textarea>
                                <small class="text-muted">Full product details with formatting. Shown on product page.</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Pricing -->
                <div class="card mb-3">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0"><i class="bi bi-currency-rupee"></i> Pricing</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Minimum Price (₹)</label>
                                <input type="number" name="price_min" class="form-control" min="0" step="0.01"
                                       value="<?php echo $product['price_min']; ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Maximum Price (₹)</label>
                                <input type="number" name="price_max" class="form-control" min="0" step="0.01"
                                       value="<?php echo $product['price_max']; ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Price Unit</label>
                                <input type="text" name="price_unit" class="form-control" 
                                       value="<?php echo htmlspecialchars($product['price_unit']); ?>">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Badge (Optional)</label>
                                <input type="text" name="badge" class="form-control" 
                                       value="<?php echo htmlspecialchars($product['badge']); ?>">
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Images & Media -->
                <div class="card mb-3">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0"><i class="bi bi-images"></i> Images & Media</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Main Image (Featured)</label>
                                <?php if ($product['main_image']): ?>
                                <div class="mb-2">
                                    <img src="<?php echo FileUploader::getImagePath($product['main_image']); ?>" class="img-thumbnail" style="max-height: 150px;">
                                </div>
                                <?php endif; ?>
                                <input type="file" name="main_image" class="form-control" accept="image/*">
                                <small class="text-muted">Main image 1:1 ratio for cards. Upload new to replace. Max 2MB.</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Parallax Image</label>
                                <?php 
                                $parallaxImg = null;
                                foreach ($productImages as $img) {
                                    if ($img['image_type'] === 'parallax') {
                                        $parallaxImg = $img;
                                        break;
                                    }
                                }
                                ?>
                                <?php if ($parallaxImg): ?>
                                <div class="mb-2">
                                    <img src="<?php echo FileUploader::getImagePath($parallaxImg['image_path']); ?>" class="img-thumbnail" style="max-height: 150px;">
                                    <div class="form-check mt-1">
                                        <input type="checkbox" name="delete_parallax" value="<?php echo $parallaxImg['id']; ?>" 
                                               class="form-check-input" id="deleteParallax">
                                        <label class="form-check-label" for="deleteParallax">
                                            <small>Delete parallax image</small>
                                        </label>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <input type="file" name="parallax_image" class="form-control" accept="image/*">
                                <small class="text-muted">Single image for product details page. Upload new to replace.</small>
                            </div>
                            
                            <div class="col-12">
                                <label class="form-label fw-semibold">Video URL</label>
                                <input type="url" name="video_url" class="form-control" 
                                       value="<?php echo htmlspecialchars($product['video_url']); ?>">
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Instructions -->
                <div class="card mb-3">
                    <div class="card-header bg-warning">
                        <h6 class="mb-0"><i class="bi bi-list-ol"></i> Usage Instructions</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">YouTube Video URL (Optional)</label>
                            <input type="url" name="instructions_video" class="form-control" 
                                   placeholder="Enter YouTube video URL for usage instructions" 
                                   value="<?php echo htmlspecialchars($product['instructions_video'] ?? ''); ?>">
                            <small class="form-text text-muted">This video will be displayed with all instruction steps</small>
                        </div>
                        <hr>
                        <div id="instructionsContainer">
                            <?php if (!empty($instructions)): ?>
                                <?php foreach ($instructions as $index => $instruction): 
                                    // Handle both old format (string) and new format (array)
                                    $text = is_array($instruction) ? ($instruction['text'] ?? '') : $instruction;
                                ?>
                                <div class="instruction-item mb-2">
                                    <div class="input-group">
                                        <span class="input-group-text fw-semibold">Step <?php echo $index + 1; ?></span>
                                        <input type="text" name="instructions[]" class="form-control" 
                                               placeholder="Instruction text" 
                                               value="<?php echo htmlspecialchars($text); ?>">
                                        <button type="button" class="btn btn-danger btn-sm remove-instruction">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                            <div class="instruction-item mb-2">
                                <div class="input-group">
                                    <span class="input-group-text fw-semibold">Step 1</span>
                                    <input type="text" name="instructions[]" class="form-control" placeholder="Instruction text">
                                    <button type="button" class="btn btn-danger btn-sm remove-instruction">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="addInstruction">
                            <i class="bi bi-plus"></i> Add Instruction Step
                        </button>
                    </div>
                </div>
                
                <!-- Features -->
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0"><i class="bi bi-star"></i> Product Features</h6>
                    </div>
                    <div class="card-body">
                        <div id="featuresContainer">
                            <?php if (!empty($features)): ?>
                                <?php foreach ($features as $feature): ?>
                                <div class="feature-item mb-2">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-check-circle"></i></span>
                                        <input type="text" name="features[]" class="form-control" 
                                               value="<?php echo htmlspecialchars($feature); ?>">
                                        <button type="button" class="btn btn-danger btn-sm remove-feature">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                            <div class="feature-item mb-2">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-check-circle"></i></span>
                                    <input type="text" name="features[]" class="form-control">
                                    <button type="button" class="btn btn-danger btn-sm remove-feature">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="addFeature">
                            <i class="bi bi-plus"></i> Add Feature
                        </button>
                    </div>
                </div>
                
                <!-- Specifications -->
                <div class="card mb-3">
                    <div class="card-header bg-secondary text-white">
                        <h6 class="mb-0"><i class="bi bi-gear"></i> Technical Specifications</h6>
                    </div>
                    <div class="card-body">
                        <div id="specificationsContainer">
                            <?php if (!empty($specifications)): ?>
                                <?php foreach ($specifications as $label => $value): ?>
                                <div class="specification-item mb-2">
                                    <div class="row g-2">
                                        <div class="col-md-4">
                                            <input type="text" name="specifications[label][]" class="form-control" 
                                                   value="<?php echo htmlspecialchars($label); ?>">
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" name="specifications[value][]" class="form-control" 
                                                   value="<?php echo htmlspecialchars($value); ?>">
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-danger btn-sm remove-specification">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                            <div class="specification-item mb-2">
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <input type="text" name="specifications[label][]" class="form-control">
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" name="specifications[value][]" class="form-control">
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger btn-sm remove-specification">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="addSpecification">
                            <i class="bi bi-plus"></i> Add Specification
                        </button>
                    </div>
                </div>
                
                <!-- SEO Meta Tags -->
                <div class="card mb-3">
                    <div class="card-header bg-dark text-white">
                        <h6 class="mb-0"><i class="bi bi-search"></i> SEO Metadata</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Meta Title</label>
                                <input type="text" name="meta_title" class="form-control" 
                                       value="<?php echo htmlspecialchars($product['meta_title']); ?>">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Meta Description</label>
                                <textarea name="meta_description" class="form-control" rows="2"><?php echo htmlspecialchars($product['meta_description']); ?></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Meta Keywords</label>
                                <input type="text" name="meta_keywords" class="form-control" 
                                       value="<?php echo htmlspecialchars($product['meta_keywords']); ?>">
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-save"></i> Update Product
                            </button>
                            <a href="products.php" class="btn btn-secondary btn-lg">
                                <i class="bi bi-x-circle"></i> Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/admin.js"></script>
    <script>
    // Auto-generate slug from product name
    const productNameInput = document.getElementById('productName');
    const slugManualInput = document.getElementById('slugManual');
    const slugAutoCheckbox = document.getElementById('slugAuto');
    
    function generateSlug(text) {
        return text
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .replace(/^-+|-+$/g, '');
    }
    
    // Auto-generate slug when typing product name (if auto is checked)
    productNameInput.addEventListener('input', function() {
        if (slugAutoCheckbox.checked) {
            slugManualInput.value = generateSlug(this.value);
        }
    });
    
    // When auto checkbox is toggled
    slugAutoCheckbox.addEventListener('change', function() {
        if (this.checked) {
            slugManualInput.value = generateSlug(productNameInput.value);
            slugManualInput.setAttribute('readonly', true);
        } else {
            slugManualInput.removeAttribute('readonly');
        }
    });
    
    // Set initial state
    if (slugAutoCheckbox.checked && !slugManualInput.value) {
        slugManualInput.value = generateSlug(productNameInput.value);
        slugManualInput.setAttribute('readonly', true);
    }
    
    // Initialize CKEditor 5 - Free Rich Text Editor
    let editorInstance;
    ClassicEditor
        .create(document.querySelector('#detailsEditor'), {
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'underline', '|',
                    'link', 'bulletedList', 'numberedList', '|',
                    'indent', 'outdent', '|',
                    'blockQuote', 'insertTable', '|',
                    'undo', 'redo'
                ]
            },
            table: {
                contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
            }
        })
        .then(editor => {
            editorInstance = editor;
            console.log('CKEditor initialized successfully');
        })
        .catch(error => {
            console.error('CKEditor initialization error:', error);
        });
    
    // Same dynamic field scripts as add-product.php
    let instructionCount = <?php echo count($instructions) ?: 1; ?>;
    document.getElementById('addInstruction').addEventListener('click', function() {
        instructionCount++;
        const container = document.getElementById('instructionsContainer');
        const newItem = document.createElement('div');
        newItem.className = 'instruction-item mb-2';
        newItem.innerHTML = `
            <div class="input-group">
                <span class="input-group-text fw-semibold">Step ${instructionCount}</span>
                <input type="text" name="instructions[]" class="form-control" placeholder="Instruction text">
                <button type="button" class="btn btn-danger btn-sm remove-instruction">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        `;
        container.appendChild(newItem);
    });
    
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-instruction')) {
            const item = e.target.closest('.instruction-item');
            if (document.querySelectorAll('.instruction-item').length > 1) {
                item.remove();
                updateInstructionNumbers();
            }
        }
    });
    
    function updateInstructionNumbers() {
        document.querySelectorAll('.instruction-item').forEach((item, index) => {
            item.querySelector('.input-group-text').textContent = `Step ${index + 1}`;
        });
        instructionCount = document.querySelectorAll('.instruction-item').length;
    }
    
    document.getElementById('addFeature').addEventListener('click', function() {
        const container = document.getElementById('featuresContainer');
        const newItem = document.createElement('div');
        newItem.className = 'feature-item mb-2';
        newItem.innerHTML = `
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-check-circle"></i></span>
                <input type="text" name="features[]" class="form-control">
                <button type="button" class="btn btn-danger btn-sm remove-feature">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        `;
        container.appendChild(newItem);
    });
    
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-feature')) {
            const item = e.target.closest('.feature-item');
            if (document.querySelectorAll('.feature-item').length > 1) {
                item.remove();
            }
        }
    });
    
    document.getElementById('addSpecification').addEventListener('click', function() {
        const container = document.getElementById('specificationsContainer');
        const newItem = document.createElement('div');
        newItem.className = 'specification-item mb-2';
        newItem.innerHTML = `
            <div class="row g-2">
                <div class="col-md-4">
                    <input type="text" name="specifications[label][]" class="form-control">
                </div>
                <div class="col-md-7">
                    <input type="text" name="specifications[value][]" class="form-control">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger btn-sm remove-specification">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        `;
        container.appendChild(newItem);
    });
    
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-specification')) {
            const item = e.target.closest('.specification-item');
            if (document.querySelectorAll('.specification-item').length > 1) {
                item.remove();
            }
        }
    });
    </script>
</body>
</html>
