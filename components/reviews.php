<?php
function getReviewsSection() {
    require_once __DIR__ . '/../config/Database.php';
    
    // Fetch active reviews marked for homepage display (homepage or both)
    $db = Database::getInstance();
    $reviews = $db->fetchAll("SELECT * FROM reviews WHERE status = 'active' AND (display_location = 'homepage' OR display_location = 'both') ORDER BY created_at DESC LIMIT 12");
    
    // If no reviews, return empty
    if (empty($reviews)) {
        return '';
    }
    
    ob_start();
?>
<!-- Customer Reviews Section -->
<section class="bg-gradient-to-b from-white to-gray-50 py-16 sm:py-20 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12">
        <!-- Section Header -->
        <div class="text-center mb-12">
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 mb-4">What Our Clients Say</h2>
            <div class="w-24 h-1 bg-yellow-500 mx-auto mb-4"></div>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Trusted by leading healthcare facilities worldwide for quality CSSD solutions
            </p>
        </div>

        <!-- Reviews Carousel -->
        <div class="relative">
            <!-- Gradient Overlays -->
            <div class="absolute left-0 top-0 bottom-0 w-20 bg-gradient-to-r from-gray-50 to-transparent z-10 pointer-events-none"></div>
            <div class="absolute right-0 top-0 bottom-0 w-20 bg-gradient-to-l from-gray-50 to-transparent z-10 pointer-events-none"></div>
            
            <!-- Scrolling Container -->
            <div class="reviews-scroll-container overflow-hidden">
                <div class="reviews-scroll-track flex gap-6 animate-scroll">
                    <?php 
                    // Output reviews twice for seamless infinite scroll
                    for ($i = 0; $i < 2; $i++):
                        foreach ($reviews as $review): 
                    ?>
                    <div class="review-card flex-shrink-0 w-80 sm:w-96 bg-white rounded-2xl shadow-lg p-6 sm:p-8 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                <?php echo strtoupper(substr($review['customer_name'], 0, 2)); ?>
                            </div>
                            <div class="ml-4">
                                <h4 class="font-bold text-gray-900"><?php echo htmlspecialchars($review['customer_name']); ?></h4>
                                <p class="text-sm text-gray-600"><?php echo htmlspecialchars($review['customer_role'] ?? ''); ?></p>
                            </div>
                        </div>
                        <div class="flex mb-3">
                            <?php for ($star = 0; $star < 5; $star++): ?>
                            <svg class="w-5 h-5 <?php echo $star < $review['rating'] ? 'text-yellow-500' : 'text-gray-300'; ?>" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <?php endfor; ?>
                        </div>
                        <p class="text-gray-700 leading-relaxed">"<?php echo htmlspecialchars($review['comment']); ?>"</p>
                    </div>
                    <?php 
                        endforeach;
                    endfor;
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
@keyframes scroll {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(calc(-400px * <?php echo count($reviews); ?> - 1.5rem * <?php echo count($reviews); ?>));
    }
}

.animate-scroll {
    animation: scroll 40s linear infinite;
}

.reviews-scroll-container:hover .animate-scroll {
    animation-play-state: paused;
}
</style>
<?php
    return ob_get_clean();
}
?>