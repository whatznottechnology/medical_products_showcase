// Product filtering functionality for Our Products page
document.addEventListener('DOMContentLoaded', function() {
    const categoryBtns = document.querySelectorAll('.category-btn');
    const productCards = document.querySelectorAll('.product-card');

    if (categoryBtns.length === 0) return;

    // Filter products by category
    function filterProducts(category) {
        productCards.forEach(card => {
            const cardCategory = card.dataset.category;
            if (category === 'all' || cardCategory === category) {
                card.classList.remove('hidden');
                setTimeout(() => {
                    card.classList.remove('scale-95', 'opacity-0');
                }, 50);
            } else {
                card.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    card.classList.add('hidden');
                }, 300);
            }
        });
    }

    // Handle category button clicks
    categoryBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            // Update active state
            categoryBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            // Filter products
            filterProducts(btn.dataset.category);
        });
    });

    // Initialize scroll animations
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.remove('scale-95', 'opacity-0');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1
    });

    productCards.forEach(card => {
        card.classList.add('scale-95', 'opacity-0');
        observer.observe(card);
    });
});
