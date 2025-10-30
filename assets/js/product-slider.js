// Product slider functionality
let currentSlide = 0;
const slider = document.getElementById('productSlider');
const totalProducts = 6;
const productsPerView = 3;
const maxSlide = totalProducts - productsPerView;

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
