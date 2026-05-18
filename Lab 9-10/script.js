// Mobile Menu Toggle
document.addEventListener('DOMContentLoaded', function() {
    const mobileToggle = document.getElementById('mobile-menu-toggle');
    const nav = document.querySelector('.nav');
    
    if (mobileToggle && nav) {
        mobileToggle.addEventListener('click', function() {
            nav.classList.toggle('active');
            const isExpanded = nav.classList.contains('active');
            mobileToggle.setAttribute('aria-expanded', isExpanded);
        });
    }
    
    // Close menu when clicking outside
    document.addEventListener('click', function(e) {
        if (nav && !nav.contains(e.target) && !mobileToggle.contains(e.target)) {
            nav.classList.remove('active');
            mobileToggle.setAttribute('aria-expanded', 'false');
        }
    });
});

// NOTE: old scroll observers removed.

// Add ripple effect to buttons
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn, .category-link, .nav-link, .btn-add-to-cart').forEach(button => {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');
            
            this.style.position = 'relative';
            this.style.overflow = 'hidden';
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
});

// Update cart badge
document.addEventListener('DOMContentLoaded', function() {
    function updateCartBadge() {
        const cartBadge = document.getElementById('cart-badge');
        if (cartBadge) {
            // This would typically fetch from server
            // For now, we'll check localStorage or count items
            const cartCount = localStorage.getItem('cartCount') || 0;
            if (cartCount > 0) {
                cartBadge.textContent = cartCount;
                cartBadge.style.display = 'flex';
            } else {
                cartBadge.style.display = 'none';
            }
        }
    }
    updateCartBadge();
});

// Add to cart functionality (for quick add buttons)
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-add-to-cart').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const productId = this.dataset.productId;
            if (!productId) return;
            
            // Disable button during request
            this.disabled = true;
            this.innerHTML = '<span class="btn-icon">⏳</span>';
            
            // Create form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'cart.php';
            
            const productInput = document.createElement('input');
            productInput.type = 'hidden';
            productInput.name = 'product_id';
            productInput.value = productId;
            
            const quantityInput = document.createElement('input');
            quantityInput.type = 'hidden';
            quantityInput.name = 'quantity';
            quantityInput.value = '1';
            
            const submitInput = document.createElement('input');
            submitInput.type = 'hidden';
            submitInput.name = 'add_to_cart';
            submitInput.value = '1';
            
            form.appendChild(productInput);
            form.appendChild(quantityInput);
            form.appendChild(submitInput);
            document.body.appendChild(form);
            form.submit();
        });
    });
});

// Smooth scroll for anchor links
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href === '#') return;
            
            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});

// Removed legacy hero parallax/counter/stagger/lazyload/injected styles.

// Form validation enhancement
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.style.borderColor = '#FF6B00';
                    field.style.boxShadow = '0 0 10px rgba(255, 107, 0, 0.45)';
                } else {
                    field.style.borderColor = '';
                    field.style.boxShadow = '';
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Будь ласка, заповніть всі обов\'язкові поля');
            }
        });
    });
});

// Add loading state to buttons
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                const originalText = submitBtn.textContent || submitBtn.value;
                submitBtn.textContent = 'Завантаження...';
                submitBtn.value = 'Завантаження...';
                
                // Re-enable after 5 seconds as fallback
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                    submitBtn.value = originalText;
                }, 5000);
            }
        });
    });
});

// Scroll reveal for new UI (fade + slide)
document.addEventListener('DOMContentLoaded', function() {
    const prefersReduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    const targets = document.querySelectorAll(
        '.hero-section, ' +
        '.features-section, ' +
        '.categories-section, ' +
        '.products-section, ' +
        '.cta-section, ' +
        '.footer, ' +
        '.cart-section, ' +
        '.checkout-container, ' +
        '.admin-container, ' +
        '.product-detail-section, ' +
        '.category-header, ' +
        '.breadcrumbs, ' +
        '.product-card, ' +
        '.feature-card, ' +
        '.category-link, ' +
        '.cart-item, ' +
        '.admin-section, ' +
        '.summary-card, ' +
        '.order-summary, ' +
        '.checkout-form'
    );

    if (!targets.length) return;

    targets.forEach((el) => el.classList.add('reveal'));

    if (prefersReduced) {
        targets.forEach((el) => el.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting && entry.target) {
                entry.target.classList.add('is-visible');
            }
        });
    }, {
        threshold: 0.12,
        rootMargin: '0px 0px -15% 0px'
    });

    targets.forEach((el) => observer.observe(el));
});
