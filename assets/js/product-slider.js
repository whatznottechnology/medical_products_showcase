// Product slider functionality
let currentSlide = 0;
const slider = document.getElementById('productSlider');
const totalProducts = 6;
const productsPerView = 3;
const maxSlide = totalProducts - productsPerView;

// Touch event variables
let touchStartX = 0;
let touchEndX = 0;
let isDragging = false;

function slideLeft() {
    if (currentSlide > 0) {
        currentSlide--;
        updateSliderPosition();
    }
}

function slideRight() {
    if (currentSlide < maxSlide) {
        currentSlide++;
        updateSliderPosition();
    }
}

function updateSliderPosition() {
    const slideWidth = 100 / productsPerView;
    const translateX = -currentSlide * slideWidth;
    slider.style.transform = `translateX(${translateX}%)`;
}

// Touch event handlers for mobile swipe
function handleTouchStart(e) {
    touchStartX = e.touches[0].clientX;
    isDragging = true;
}

function handleTouchMove(e) {
    if (!isDragging) return;
    touchEndX = e.touches[0].clientX;
}

function handleTouchEnd() {
    if (!isDragging) return;
    isDragging = false;
    
    const swipeThreshold = 50; // Minimum swipe distance
    const swipeDistance = touchStartX - touchEndX;
    
    if (Math.abs(swipeDistance) > swipeThreshold) {
        if (swipeDistance > 0) {
            // Swiped left - go to next slide
            slideRight();
        } else {
            // Swiped right - go to previous slide
            slideLeft();
        }
    }
    
    touchStartX = 0;
    touchEndX = 0;
}

// Add touch event listeners when slider is available
if (slider) {
    slider.addEventListener('touchstart', handleTouchStart, { passive: true });
    slider.addEventListener('touchmove', handleTouchMove, { passive: true });
    slider.addEventListener('touchend', handleTouchEnd, { passive: true });
}
