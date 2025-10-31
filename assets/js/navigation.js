// Navigation and Mobile Drawer functionality
document.addEventListener('DOMContentLoaded', function() {
    const nav = document.querySelector('nav');
    const navContainer = document.getElementById('navContainer');
    const navLogo = document.getElementById('navLogo');
    const navButton = document.getElementById('navButton');
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileDrawer = document.getElementById('mobileDrawer');
    const drawerPanel = document.getElementById('drawerPanel');
    const drawerOverlay = document.getElementById('drawerOverlay');
    const drawerCloseBtn = document.getElementById('drawerCloseBtn');
    const hamburgerIcon = document.getElementById('hamburgerIcon');
    const closeIcon = document.getElementById('closeIcon');
    let lastScroll = 0;

    // Scroll behavior
    window.addEventListener('scroll', function() {
        const currentScroll = window.pageYOffset;

        // Add scroll class when scrolling down
        if (currentScroll > 50) {
            nav.classList.add('bg-black/40');
            navContainer.classList.remove('py-4');
            navContainer.classList.add('py-2');
            navLogo.classList.remove('text-lg', 'sm:text-xl', 'lg:text-2xl');
            navLogo.classList.add('text-base', 'sm:text-lg', 'lg:text-xl');
            if (navButton) {
                navButton.classList.remove('px-5', 'py-2');
                navButton.classList.add('px-4', 'py-1.5');
            }
        } else {
            nav.classList.remove('bg-black/40');
            navContainer.classList.remove('py-2');
            navContainer.classList.add('py-4');
            navLogo.classList.remove('text-base', 'sm:text-lg', 'lg:text-xl');
            navLogo.classList.add('text-lg', 'sm:text-xl', 'lg:text-2xl');
            if (navButton) {
                navButton.classList.remove('px-4', 'py-1.5');
                navButton.classList.add('px-5', 'py-2');
            }
        }

        lastScroll = currentScroll;
    });

    // Mobile drawer functionality
    function openDrawer() {
        mobileDrawer.classList.remove('pointer-events-none');
        drawerPanel.classList.remove('translate-x-full');
        drawerOverlay.classList.remove('bg-black/0', 'backdrop-blur-0');
        drawerOverlay.classList.add('bg-black/50', 'backdrop-blur-sm');
        hamburgerIcon.classList.add('hidden');
        closeIcon.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeDrawer() {
        drawerPanel.classList.add('translate-x-full');
        drawerOverlay.classList.remove('bg-black/50', 'backdrop-blur-sm');
        drawerOverlay.classList.add('bg-black/0', 'backdrop-blur-0');
        hamburgerIcon.classList.remove('hidden');
        closeIcon.classList.add('hidden');
        document.body.style.overflow = '';
        
        setTimeout(() => {
            mobileDrawer.classList.add('pointer-events-none');
        }, 300);
    }

    // Toggle drawer on button click
    mobileMenuBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        if (drawerPanel.classList.contains('translate-x-full')) {
            openDrawer();
        } else {
            closeDrawer();
        }
    });

    // Close drawer with close button
    drawerCloseBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        closeDrawer();
    });

    // Close drawer when clicking overlay
    drawerOverlay.addEventListener('click', closeDrawer);

    // Close drawer when clicking a link
    const drawerLinks = drawerPanel.querySelectorAll('a');
    drawerLinks.forEach(link => {
        link.addEventListener('click', closeDrawer);
    });

    // Close drawer on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !drawerPanel.classList.contains('translate-x-full')) {
            closeDrawer();
        }
    });

    // Prevent drawer close when clicking inside panel
    drawerPanel.addEventListener('click', function(e) {
        e.stopPropagation();
    });

    // Prevent body scroll when drawer is open (iOS fix)
    let scrollPosition = 0;
    const preventScroll = () => {
        scrollPosition = window.pageYOffset;
        document.body.style.position = 'fixed';
        document.body.style.top = `-${scrollPosition}px`;
        document.body.style.width = '100%';
    };

    const allowScroll = () => {
        document.body.style.position = '';
        document.body.style.top = '';
        document.body.style.width = '';
        window.scrollTo(0, scrollPosition);
    };

    // Update open/close drawer functions for iOS
    const originalOpenDrawer = openDrawer;
    openDrawer = function() {
        originalOpenDrawer();
        preventScroll();
    };

    const originalCloseDrawer = closeDrawer;
    closeDrawer = function() {
        originalCloseDrawer();
        allowScroll();
    };
});
