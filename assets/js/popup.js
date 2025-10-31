// assets/js/popup.js
document.addEventListener('DOMContentLoaded', function() {
    const popup = document.getElementById('leadPopup');
    const closeBtn = document.getElementById('closePopup');
    
    // Prevent any URL issues during popup display
    let popupShown = false;

    // Show popup after 5 seconds
    setTimeout(() => {
        if (!popupShown && popup) {
            popup.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
            popupShown = true;
        }
    }, 5000);

    // Close popup function
    function closePopup() {
        if (popup) {
            popup.classList.add('hidden');
            document.body.style.overflow = 'auto'; // Restore scrolling
            popupShown = false;
        }
    }

    // Close on button click
    if (closeBtn) {
        closeBtn.addEventListener('click', closePopup);
    }

    // Close on outside click
    if (popup) {
        popup.addEventListener('click', function(e) {
            if (e.target === popup) {
                closePopup();
            }
        });
    }

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && popup && !popup.classList.contains('hidden')) {
            closePopup();
        }
    });
    
    // Export closePopup function for use by popup.php component
    window.closeLeadPopup = closePopup;
});