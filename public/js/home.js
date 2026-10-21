/**
 * Hospital Management System - Modern Healthcare Landing Page Scripts
 * Aura Hospital Theme - Seamless Infinite Card-by-Card Carousel & Interactive Utilities
 */

// Global True Infinite Seamless Card-by-Card Carousel Component
window.infiniteCarousel = () => ({
    isAnimating: false,
    safetyTimer: null,

    getTrack() {
        return this.$refs.track || this.$refs.slider;
    },

    next() {
        if (this.isAnimating) return;
        const track = this.getTrack();
        if (!track || track.children.length <= 1) return;

        const firstCard = track.firstElementChild;
        const gap = parseFloat(getComputedStyle(track).gap) || 24;
        const step = firstCard.offsetWidth + gap;
        const isRtl = document.documentElement.dir === 'rtl';
        const dir = isRtl ? 1 : -1;

        this.isAnimating = true;

        track.style.transition = 'transform 0.45s cubic-bezier(0.16, 1, 0.3, 1)';
        track.style.transform = `translateX(${dir * step}px)`;

        const cleanup = () => {
            if (this.safetyTimer) {
                clearTimeout(this.safetyTimer);
                this.safetyTimer = null;
            }
            track.removeEventListener('transitionend', onEnd);
            track.style.transition = 'none';
            track.style.transform = 'translateX(0)';
            track.appendChild(firstCard);
            setTimeout(() => {
                this.isAnimating = false;
            }, 30);
        };

        const onEnd = () => cleanup();
        this.safetyTimer = setTimeout(cleanup, 550);
        track.addEventListener('transitionend', onEnd, { once: true });
    },

    prev() {
        if (this.isAnimating) return;
        const track = this.getTrack();
        if (!track || track.children.length <= 1) return;

        const lastCard = track.lastElementChild;
        const gap = parseFloat(getComputedStyle(track).gap) || 24;
        const step = lastCard.offsetWidth + gap;
        const isRtl = document.documentElement.dir === 'rtl';
        const dir = isRtl ? 1 : -1;

        this.isAnimating = true;

        // 1. Move last card to front instantly with offset so visual positions don't jump
        track.style.transition = 'none';
        track.insertBefore(lastCard, track.firstElementChild);
        track.style.transform = `translateX(${dir * step}px)`;

        // 2. Force reflow to commit initial transform
        void track.offsetHeight;

        // 3. Smoothly animate to 0
        track.style.transition = 'transform 0.45s cubic-bezier(0.16, 1, 0.3, 1)';
        track.style.transform = 'translateX(0)';

        const cleanup = () => {
            if (this.safetyTimer) {
                clearTimeout(this.safetyTimer);
                this.safetyTimer = null;
            }
            track.removeEventListener('transitionend', onEnd);
            track.style.transition = 'none';
            setTimeout(() => {
                this.isAnimating = false;
            }, 30);
        };

        const onEnd = () => cleanup();
        this.safetyTimer = setTimeout(cleanup, 550);
        track.addEventListener('transitionend', onEnd, { once: true });
    }
});

// Alias for backwards compatibility
window.carouselSlider = window.infiniteCarousel;

document.addEventListener('DOMContentLoaded', () => {
    // 1. Reading / Scroll Progress Bar
    const progressBar = document.getElementById('scroll-progress-bar');
    const updateProgressBar = () => {
        if (!progressBar) return;
        const totalHeight = document.documentElement.scrollHeight - window.innerHeight;
        const progress = totalHeight > 0 ? (window.scrollY / totalHeight) * 100 : 0;
        progressBar.style.width = `${Math.min(100, Math.max(0, progress))}%`;
    };

    window.addEventListener('scroll', updateProgressBar, { passive: true });
    updateProgressBar();

    // 2. IntersectionObserver Scroll Reveal with Smooth Stagger
    const revealElements = document.querySelectorAll('.reveal');
    if ('IntersectionObserver' in window && revealElements.length > 0) {
        const revealObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -40px 0px'
        });

        revealElements.forEach(el => revealObserver.observe(el));
    } else {
        revealElements.forEach(el => el.classList.add('revealed'));
    }

    // 3. Smooth Stats Counter Animation
    const counterElements = document.querySelectorAll('[data-counter]');
    const animateCounter = (el) => {
        const rawTarget = el.getAttribute('data-counter');
        const target = parseFloat(rawTarget);
        if (isNaN(target)) return;

        const isFloat = rawTarget.includes('.');
        const formatComma = el.hasAttribute('data-format');
        const prefix = el.getAttribute('data-prefix') || '';
        const suffix = el.getAttribute('data-suffix') || '';
        const duration = 2000; // ms
        const startTime = performance.now();

        const updateCount = (currentTime) => {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            // Ease out expo for smooth deceleration
            const easeOut = progress === 1 ? 1 : 1 - Math.pow(2, -10 * progress);

            let currentVal = isFloat
                ? (easeOut * target).toFixed(1)
                : Math.floor(easeOut * target);

            let formattedVal = currentVal;
            if (formatComma && !isFloat) {
                formattedVal = Number(currentVal).toLocaleString('en-US');
            }

            el.textContent = `${prefix}${formattedVal}${suffix}`;

            if (progress < 1) {
                requestAnimationFrame(updateCount);
            } else {
                const finalFormatted = formatComma && !isFloat
                    ? Number(target).toLocaleString('en-US')
                    : target;
                el.textContent = `${prefix}${finalFormatted}${suffix}`;
            }
        };

        requestAnimationFrame(updateCount);
    };

    if ('IntersectionObserver' in window && counterElements.length > 0) {
        const counterObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.25 });

        counterElements.forEach(el => counterObserver.observe(el));
    } else {
        counterElements.forEach(el => {
            const rawTarget = el.getAttribute('data-counter');
            const target = parseFloat(rawTarget);
            const formatComma = el.hasAttribute('data-format');
            const prefix = el.getAttribute('data-prefix') || '';
            const suffix = el.getAttribute('data-suffix') || '';
            const finalFormatted = formatComma ? Number(target).toLocaleString('en-US') : target;
            el.textContent = `${prefix}${finalFormatted}${suffix}`;
        });
    }

    // 4. Floating Back to Top Button
    const backToTopBtn = document.getElementById('back-to-top-btn');
    if (backToTopBtn) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 350) {
                backToTopBtn.classList.add('visible');
            } else {
                backToTopBtn.classList.remove('visible');
            }
        }, { passive: true });

        backToTopBtn.addEventListener('click', (e) => {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // 5. Interactive Ripple on Buttons
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.btn-ripple');
        if (!btn) return;

        const rect = btn.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        const ripple = document.createElement('span');
        ripple.style.position = 'absolute';
        ripple.style.left = `${x}px`;
        ripple.style.top = `${y}px`;
        ripple.style.width = '20px';
        ripple.style.height = '20px';
        ripple.style.borderRadius = '50%';
        ripple.style.background = 'rgba(255, 255, 255, 0.45)';
        ripple.style.transform = 'translate(-50%, -50%) scale(0)';
        ripple.style.pointerEvents = 'none';
        ripple.style.transition = 'transform 0.6s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.6s ease';

        btn.appendChild(ripple);

        requestAnimationFrame(() => {
            ripple.style.transform = 'translate(-50%, -50%) scale(22)';
            ripple.style.opacity = '0';
        });

        setTimeout(() => ripple.remove(), 650);
    });
});
