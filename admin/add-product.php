<?php
/**
 * Add New Product - Dedicated Page
 */

require_once '../config/Database.php';
require_once '../config/Auth.php';
require_once '../config/FileUploader.php';

Auth::require();

$db = Database::getInstance();
$user = Auth::user();
$message = '';
$messageType = '';

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && Auth::verifyToken($_POST['csrf_token'] ?? '')) {
    try {
        $uploader = new FileUploader('uploads/products/');
        
        // Process specifications (convert label-value pairs to associative array)
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
        
        // Process instructions (simple text array)
        $instructions = array_filter($_POST['instructions'] ?? [], function($val) {
            return !empty(trim($val));
        });
        
        $features = array_filter($_POST['features'] ?? [], function($val) {
            return !empty(trim($val));
        });
        
        // Generate slug (manual takes priority, otherwise auto-generate from name)
        $slug = null;
        $slugColumnExists = false;
        try {
            // Check if slug column exists
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
            
            // Ensure slug is unique
            if (!empty($slug)) {
                $baseSlug = $slug;
                $counter = 1;
                while ($db->fetchOne("SELECT id FROM products WHERE slug = ?", [$slug])) {
                    $slug = $baseSlug . '-' . $counter;
                    $counter++;
                }
            }
        } catch (PDOException $e) {
            // Slug column doesn't exist yet, skip it
            $slugColumnExists = false;
            $slug = null;
        }
        
        // Check if instructions_video column exists
        $instructionsVideoColumnExists = false;
        try {
            $db->query("SELECT instructions_video FROM products LIMIT 1");
            $instructionsVideoColumnExists = true;
        } catch (Exception $e) {
            $instructionsVideoColumnExists = false;
        }
        
        // Prepare product data
        $productData = [
            'name' => $_POST['name'] ?? '',
            'subtitle' => $_POST['subtitle'] ?? '',
            'description' => $_POST['description'] ?? '',
            'details' => $_POST['details'] ?? '', // Rich text content
            'price_min' => !empty($_POST['price_min']) ? (float)$_POST['price_min'] : null,
            'price_max' => !empty($_POST['price_max']) ? (float)$_POST['price_max'] : null,
            'price_unit' => $_POST['price_unit'] ?? '',
            'badge' => $_POST['badge'] ?? '',
            'video_url' => $_POST['video_url'] ?? '',
            'instructions' => json_encode($instructions),
            'features' => json_encode(array_values($features)),
            'specifications' => json_encode($specifications),
            'meta_title' => $_POST['meta_title'] ?? '',
            'meta_description' => $_POST['meta_description'] ?? '',
            'meta_keywords' => $_POST['meta_keywords'] ?? '',
            'status' => $_POST['status'] ?? 'active'
        ];
        
        // Add slug only if it was successfully generated
        if ($slug !== null) {
            $productData['slug'] = $slug;
        }
        
        // Add instructions_video only if column exists
        if ($instructionsVideoColumnExists) {
            $productData['instructions_video'] = $_POST['instructions_video'] ?? '';
        }
        
        // Upload main image (required)
        if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] === UPLOAD_ERR_OK) {
            $result = $uploader->upload($_FILES['main_image']);
            if (!isset($result['error'])) {
                $productData['main_image'] = $result;
            } else {
                throw new Exception('Failed to upload main image');
            }
        } else {
            throw new Exception('Main image is required');
        }
        
        // Insert product
        $productId = $db->insert('products', $productData);
        
        // Handle single parallax image upload
        if (isset($_FILES['parallax_image']) && $_FILES['parallax_image']['error'] === UPLOAD_ERR_OK) {
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
        
        $message = 'Product added successfully!';
        $messageType = 'success';
        
        // Redirect to products list after 2 seconds
        header("refresh:2;url=products.php");
        
    } catch (Exception $e) {
        $message = 'Error saving product: ' . $e->getMessage();
        $messageType = 'danger';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - ZEGNEN Admin</title>
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
                        <i class="bi bi-plus-circle"></i> Add New Product
                    </h1>
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
                                       placeholder="e.g., Steam Sterilizer">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Subtitle</label>
                                <input type="text" name="subtitle" class="form-control" 
                                       placeholder="e.g., High-Pressure Autoclave">
                            </div>
                            
                            <!-- Slug Field (SEO-friendly URL) -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">URL Slug (SEO-friendly)</label>
                                <div class="input-group mb-2">
                                    <span class="input-group-text">/product/</span>
                                    <input type="text" name="slug_manual" id="slugManual" class="form-control" 
                                           placeholder="auto-generated-from-title">
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
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Short Description</label>
                                <textarea name="description" class="form-control" rows="3" 
                                          placeholder="Brief product overview (shown in product cards)"></textarea>
                                <small class="text-muted">Plain text only. Shown on product listing cards.</small>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Detailed Description <span class="text-danger">*</span></label>
                                <textarea name="details" id="detailsEditor" class="form-control" rows="10"></textarea>
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
                                       placeholder="10000">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Maximum Price (₹)</label>
                                <input type="number" name="price_max" class="form-control" min="0" step="0.01"
                                       placeholder="50000">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Price Unit</label>
                                <input type="text" name="price_unit" class="form-control" 
                                       placeholder="e.g., per unit, per set">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Badge (Optional)</label>
                                <input type="text" name="badge" class="form-control" 
                                       placeholder="e.g., Best Seller, New Arrival, Hot Deal">
                                <small class="text-muted">This will display as a badge on the product card</small>
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
                                <label class="form-label fw-semibold">Main Image (Featured) <span class="text-danger">*</span></label>
                                <input type="file" name="main_image" class="form-control" accept="image/*" required>
                                <small class="text-muted">Main product image 1:1 ratio for cards (JPG, PNG, WEBP). Max 2MB.</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Parallax Image</label>
                                <input type="file" name="parallax_image" class="form-control" accept="image/*">
                                <small class="text-muted">Single image for product details page parallax section.</small>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Video URL (YouTube/Vimeo)</label>
                                <input type="url" name="video_url" class="form-control" 
                                       placeholder="https://www.youtube.com/watch?v=...">
                                <small class="text-muted">Optional product demonstration video</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Instructions (Dynamic) -->
                <div class="card mb-3">
                    <div class="card-header bg-warning">
                        <h6 class="mb-0"><i class="bi bi-list-ol"></i> Usage Instructions</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">YouTube Video URL (Optional)</label>
                            <input type="url" name="instructions_video" class="form-control" 
                                   placeholder="Enter YouTube video URL for usage instructions">
                            <small class="form-text text-muted">This video will be displayed with all instruction steps</small>
                        </div>
                        <hr>
                        <div id="instructionsContainer">
                            <div class="instruction-item mb-2">
                                <div class="input-group">
                                    <span class="input-group-text fw-semibold">Step 1</span>
                                    <input type="text" name="instructions[]" class="form-control" 
                                           placeholder="Instruction text">
                                    <button type="button" class="btn btn-danger btn-sm remove-instruction">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="addInstruction">
                            <i class="bi bi-plus"></i> Add Instruction Step
                        </button>
                    </div>
                </div>
                
                <!-- Features (Dynamic) -->
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0"><i class="bi bi-star"></i> Product Features</h6>
                    </div>
                    <div class="card-body">
                        <div id="featuresContainer">
                            <div class="feature-item mb-2">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-check-circle"></i></span>
                                    <input type="text" name="features[]" class="form-control" 
                                           placeholder="Advanced temperature control system">
                                    <button type="button" class="btn btn-danger btn-sm remove-feature">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="addFeature">
                            <i class="bi bi-plus"></i> Add Feature
                        </button>
                    </div>
                </div>
                
                <!-- Specifications (Dynamic Key-Value) -->
                <div class="card mb-3">
                    <div class="card-header bg-secondary text-white">
                        <h6 class="mb-0"><i class="bi bi-gear"></i> Technical Specifications</h6>
                    </div>
                    <div class="card-body">
                        <div id="specificationsContainer">
                            <div class="specification-item mb-2">
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <input type="text" name="specifications[label][]" class="form-control" 
                                               placeholder="Label (e.g., Capacity)">
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" name="specifications[value][]" class="form-control" 
                                               placeholder="Value (e.g., 50 liters)">
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger btn-sm remove-specification">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
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
                                       placeholder="Product Name - ZEGNEN Medical Equipment">
                                <small class="text-muted">Recommended: 50-60 characters</small>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Meta Description</label>
                                <textarea name="meta_description" class="form-control" rows="2" 
                                          placeholder="Brief description for search engines"></textarea>
                                <small class="text-muted">Recommended: 150-160 characters</small>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Meta Keywords</label>
                                <input type="text" name="meta_keywords" class="form-control" 
                                       placeholder="sterilizer, autoclave, medical equipment, CSSD">
                                <small class="text-muted">Comma-separated keywords</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-save"></i> Save Product
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
    if (slugAutoCheckbox.checked) {
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
    
    // Dynamic Instructions
    let instructionCount = 1;
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
    
    // Dynamic Features
    document.getElementById('addFeature').addEventListener('click', function() {
        const container = document.getElementById('featuresContainer');
        const newItem = document.createElement('div');
        newItem.className = 'feature-item mb-2';
        newItem.innerHTML = `
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-check-circle"></i></span>
                <input type="text" name="features[]" class="form-control" placeholder="Feature description">
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
    
    // Dynamic Specifications
    document.getElementById('addSpecification').addEventListener('click', function() {
        const container = document.getElementById('specificationsContainer');
        const newItem = document.createElement('div');
        newItem.className = 'specification-item mb-2';
        newItem.innerHTML = `
            <div class="row g-2">
                <div class="col-md-4">
                    <input type="text" name="specifications[label][]" class="form-control" placeholder="Label">
                </div>
                <div class="col-md-7">
                    <input type="text" name="specifications[value][]" class="form-control" placeholder="Value">
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
