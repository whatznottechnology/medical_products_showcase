// assets/js/popup.js
document.addEventListener('DOMContentLoaded', function() {
    const popup = document.getElementById('leadPopup');
    const closeBtn = document.getElementById('closePopup');
    const leadForm = document.getElementById('leadForm');
    
    // Prevent any URL issues during popup display
    let popupShown = false;

    // Show popup after 5 seconds
    setTimeout(() => {
        if (!popupShown) {
            popup.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
            popupShown = true;
        }
    }, 5000);

    // Close popup function
    function closePopup() {
        popup.classList.add('hidden');
        document.body.style.overflow = 'auto'; // Restore scrolling
        popupShown = false;
    }

    // Close on button click
    closeBtn.addEventListener('click', closePopup);

    // Close on outside click
    popup.addEventListener('click', function(e) {
        if (e.target === popup) {
            closePopup();
        }
    });

    // Handle form submission with loading state
    leadForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const name = formData.get('name');
        const phone = formData.get('phone');
        
        // Show loading state
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalContent = submitBtn.innerHTML;
        
        // Update button with CSS-based loading spinner
        submitBtn.innerHTML = `
            <div class="flex items-center justify-center">
                <div class="loading-spinner mr-2"></div>
                <span>Sending...</span>
            </div>
        `;
        submitBtn.disabled = true;
        submitBtn.style.opacity = '0.8';

        // Simulate API call delay
        setTimeout(() => {
            // Here you would typically send data to your backend
            console.log('Lead captured:', { name, phone });

            // Show success message and close popup
            alert('Thank you! Our team will contact you soon.');
            closePopup();

            // Reset form and button
            this.reset();
            submitBtn.innerHTML = originalContent;
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
        }, 1500);
    });

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !popup.classList.contains('hidden')) {
            closePopup();
        }
    });
});