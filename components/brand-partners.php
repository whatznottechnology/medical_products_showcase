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

    <style>
        .brand-slider-container {
            overflow: hidden;
            width: 100%;
            position: relative;
            background: white;
            border-radius: 16px;
            padding: 40px 0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        }

        .brand-slider {
            display: flex;
            align-items: center;
            animation: scrollBrands 30s linear infinite;
            will-change: transform;
        }

        .brand-item {
            flex-shrink: 0;
            padding: 0 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand-logo {
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        .brand-logo:hover {
            transform: scale(1.05);
            opacity: 0.8;
        }

        .brand-image {
            max-height: 100%;
            max-width: 180px;
            width: auto;
            height: auto;
            object-fit: contain;
            filter: grayscale(100%) opacity(0.7);
            transition: all 0.3s ease;
        }

        .brand-item:hover .brand-image {
            filter: grayscale(0%) opacity(1);
        }

        @keyframes scrollBrands {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        .brand-slider-container:hover .brand-slider {
            animation-play-state: paused;
        }

        @media (max-width: 768px) {
            .brand-item {
                padding: 0 30px;
            }
            .brand-logo {
                height: 50px;
            }
            .brand-image {
                max-width: 140px;
            }
        }

        @media (max-width: 480px) {
            .brand-item {
                padding: 0 20px;
            }
            .brand-logo {
                height: 40px;
            }
            .brand-image {
                max-width: 120px;
            }
        }
    </style>
</section>
<?php
    return ob_get_clean();
}
?>