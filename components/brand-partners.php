<?php
function getBrandPartnersSection() {
    ob_start();
?>
<!-- Brand Partners Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">
        <div class="text-center mb-12">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-800 mb-4">
                Trusted by Leading Healthcare Institutions
            </h2>
            <p class="text-gray-600 text-lg">
                Our products are used in top hospitals and healthcare facilities across India
            </p>
        </div>
        
        <!-- Brand Logos Slider -->
        <div class="brand-slider-container">
            <div class="brand-slider">
                <?php
                $brands = [
                    ['name' => 'Fortis Healthcare', 'logo' => 'https://logos-world.net/wp-content/uploads/2022/01/Fortis-Healthcare-Logo.png'],
                    ['name' => 'Apollo Hospitals', 'logo' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQyJG9zl7Xy3tl8w6Lj8pHx9u6oLpNpOI_8VA&s'],
                    ['name' => 'Max Healthcare', 'logo' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSfmLnAi9I5KrN9HvjKhY8Xs2IqvYpGqJ5r9w&s'],
                    ['name' => 'Manipal Hospitals', 'logo' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQxF5cY8B9gKo2B7wL4qjGzJ9u4XhvR5t9A8w&s'],
                    ['name' => 'Medanta', 'logo' => 'https://www.medanta.org/storage/2022/06/medanta-logo.png'],
                    ['name' => 'AIIMS', 'logo' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ5KJ8wD2rN7xK9lL0Hj8Z9tQ6JgO5vR2P1wQ&s']
                ];

                // Output brands twice for infinite scroll effect
                for ($i = 0; $i < 2; $i++) {
                    foreach ($brands as $brand) {
                        echo '<div class="brand-item">
                                <div class="brand-logo">
                                    <img src="' . $brand['logo'] . '" 
                                         alt="' . $brand['name'] . '" class="brand-image">
                                </div>
                            </div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</section>

<link rel="stylesheet" href="assets/css/brand-partners.css">
<?php
    return ob_get_clean();
}
?>