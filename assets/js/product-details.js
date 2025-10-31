// Tab switching function
function switchTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.style.display = 'none';
    });
    
    // Remove active state from all buttons
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('border-yellow-500', 'text-yellow-600');
        button.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected tab content
    const selectedContent = document.getElementById('content-' + tabName);
    if (selectedContent) {
        selectedContent.style.display = 'block';
    }
    
    // Add active state to selected button
    const activeButton = document.getElementById('tab-' + tabName);
    if (activeButton) {
        activeButton.classList.remove('border-transparent', 'text-gray-500');
        activeButton.classList.add('border-yellow-500', 'text-yellow-600');
    }
}

// Reviews slider function - Updated for two rows
function scrollReviews(direction) {
    const slider1 = document.getElementById('reviewsSlider1');
    const slider2 = document.getElementById('reviewsSlider2');
    const scrollAmount = 400;
    
    if (direction === 'left') {
        slider1.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
        slider2.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    } else {
        slider1.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        slider2.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
    }
}

// Auto-scroll reviews - Updated for two rows
let autoScrollInterval1, autoScrollInterval2;

function startAutoScroll() {
    // First row - scroll left to right
    autoScrollInterval1 = setInterval(() => {
        const slider = document.getElementById('reviewsSlider1');
        if (slider.scrollLeft + slider.clientWidth >= slider.scrollWidth) {
            slider.scrollTo({ left: 0, behavior: 'smooth' });
        } else {
            slider.scrollBy({ left: 400, behavior: 'smooth' });
        }
    }, 3000);

    // Second row - scroll right to left (reverse direction)
    autoScrollInterval2 = setInterval(() => {
        const slider = document.getElementById('reviewsSlider2');
        if (slider.scrollLeft <= 0) {
            slider.scrollTo({ left: slider.scrollWidth, behavior: 'smooth' });
        } else {
            slider.scrollBy({ left: -400, behavior: 'smooth' });
        }
    }, 3000);
}

function stopAutoScroll() {
    clearInterval(autoScrollInterval1);
    clearInterval(autoScrollInterval2);
}

// Stop auto-scroll on hover for both sliders
document.getElementById('reviewsSlider1')?.addEventListener('mouseenter', stopAutoScroll);
document.getElementById('reviewsSlider2')?.addEventListener('mouseenter', stopAutoScroll);

document.getElementById('reviewsSlider1')?.addEventListener('mouseleave', startAutoScroll);
document.getElementById('reviewsSlider2')?.addEventListener('mouseleave', startAutoScroll);

// Smooth scroll to inquiry form
function scrollToInquiry() {
    const inquiryForm = document.getElementById('inquiryForm');
    if (inquiryForm) {
        const yOffset = -100; // Offset for fixed header
        const y = inquiryForm.getBoundingClientRect().top + window.pageYOffset + yOffset;
        
        window.scrollTo({
            top: y,
            behavior: 'smooth'
        });
        
        // Add highlight animation
        inquiryForm.classList.add('pulse-highlight');
        setTimeout(() => {
            inquiryForm.classList.remove('pulse-highlight');
        }, 2000);
        
        // Focus on first input after scroll
        setTimeout(() => {
            const firstInput = inquiryForm.querySelector('input[name="name"]');
            if (firstInput) {
                firstInput.focus();
            }
        }, 800);
    }
}

// Form submission handler
document.addEventListener('DOMContentLoaded', function() {
    // Start auto-scroll for reviews
    startAutoScroll();
    
    // Mobile responsiveness for parallax sections
    const handleMobileParallax = () => {
        const isMobile = window.innerWidth <= 768;
        const parallaxSections = document.querySelectorAll('.relative.overflow-hidden');
        
        parallaxSections.forEach(section => {
            if (isMobile) {
                section.classList.add('parallax-section-mobile');
            } else {
                section.classList.remove('parallax-section-mobile');
            }
        });
    };
    
    // Run on load and resize
    handleMobileParallax();
    window.addEventListener('resize', handleMobileParallax);
    
    // Quick inquiry form handler
    const quickForm = document.getElementById('quickInquiryForm');
    if (quickForm) {
        quickForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(quickForm);
            const data = {};
            formData.forEach((value, key) => {
                data[key] = value;
            });
            
            // Basic validation
            if (!data.name || !data.email || !data.phone || !data.message) {
                alert('Please fill in all required fields');
                return;
            }
            
            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(data.email)) {
                alert('Please enter a valid email address');
                return;
            }
            
            // Show success message with animation
            const submitBtn = quickForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<svg class="animate-spin h-5 w-5 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
            
            setTimeout(() => {
                submitBtn.innerHTML = '✓ Sent Successfully!';
                submitBtn.classList.add('bg-green-500');
                
                setTimeout(() => {
                    quickForm.reset();
                    submitBtn.innerHTML = originalText;
                    submitBtn.classList.remove('bg-green-500');
                }, 2000);
            }, 1000);
            
            console.log('Quick inquiry submitted:', data);
        });
    }
    
    const form = document.getElementById('productInquiryForm');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(form);
            const data = {};
            formData.forEach((value, key) => {
                data[key] = value;
            });
            
            // Basic validation
            if (!data.name || !data.email || !data.phone || !data.message) {
                alert('Please fill in all required fields');
                return;
            }
            
            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(data.email)) {
                alert('Please enter a valid email address');
                return;
            }
            
            // Show success message
            alert('Thank you for your inquiry! Our team will contact you within 24 hours.');
            
            // Reset form
            form.reset();
            
            // Scroll to top
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
            
            // In production, send data to backend
            console.log('Form submitted with data:', data);
        });
    }
    
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Mobile Parallax Effect using transform
    if (window.innerWidth <= 768) {
        const parallaxSections = document.querySelectorAll('.parallax-section-mobile');
        
        parallaxSections.forEach(section => {
            const parallaxBg = section.querySelector('.parallax-bg');
            
            if (parallaxBg) {
                window.addEventListener('scroll', () => {
                    const rect = section.getBoundingClientRect();
                    
                    // Only apply parallax when section is in viewport
                    if (rect.top < window.innerHeight && rect.bottom > 0) {
                        const scrolled = window.pageYOffset;
                        const sectionTop = section.offsetTop;
                        const offset = (scrolled - sectionTop) * 0.5;
                        parallaxBg.style.transform = `translateY(${offset}px)`;
                    }
                });
            }
        });
    }
});
