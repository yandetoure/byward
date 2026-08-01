import * as bootstrap from 'bootstrap';

window.bootstrap = bootstrap;

const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

/* ------------------------------------------------------------------
 * Scroll reveal — staggered by data-reveal-delay
 * ---------------------------------------------------------------- */
function initReveal() {
    const items = document.querySelectorAll('[data-reveal]');
    if (!items.length) return;

    if (reduceMotion || !('IntersectionObserver' in window)) {
        items.forEach((el) => el.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver(
        (entries, obs) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                const el = entry.target;
                const delay = parseInt(el.dataset.revealDelay || '0', 10);
                window.setTimeout(() => el.classList.add('is-visible'), delay);
                obs.unobserve(el);
            });
        },
        { threshold: 0.12, rootMargin: '0px 0px -60px 0px' }
    );

    items.forEach((el) => observer.observe(el));
}

/* ------------------------------------------------------------------
 * Animated counters — [data-count-to]
 * ---------------------------------------------------------------- */
function initCounters() {
    const counters = document.querySelectorAll('[data-count-to]');
    if (!counters.length) return;

    const run = (el) => {
        const target = parseFloat(el.dataset.countTo);
        const decimals = parseInt(el.dataset.countDecimals || '0', 10);
        const prefix = el.dataset.countPrefix || '';
        const suffix = el.dataset.countSuffix || '';
        const duration = 1700;
        const start = performance.now();
        const locale = document.documentElement.lang === 'fr' ? 'fr-FR' : 'en-US';

        const format = (v) =>
            prefix +
            v.toLocaleString(locale, {
                minimumFractionDigits: decimals,
                maximumFractionDigits: decimals,
            }) +
            suffix;

        if (reduceMotion) {
            el.textContent = format(target);
            return;
        }

        const tick = (now) => {
            const p = Math.min((now - start) / duration, 1);
            const eased = 1 - Math.pow(1 - p, 4);
            el.textContent = format(target * eased);
            if (p < 1) requestAnimationFrame(tick);
            else el.textContent = format(target);
        };
        requestAnimationFrame(tick);
    };

    if (!('IntersectionObserver' in window)) {
        counters.forEach(run);
        return;
    }

    const observer = new IntersectionObserver(
        (entries, obs) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                run(entry.target);
                obs.unobserve(entry.target);
            });
        },
        { threshold: 0.5 }
    );

    counters.forEach((el) => observer.observe(el));
}

/* ------------------------------------------------------------------
 * Header state + reading progress + back to top
 * ---------------------------------------------------------------- */
function initScrollUi() {
    const header = document.querySelector('.site-header');
    const progress = document.querySelector('.progress-bar-top');
    const toTop = document.querySelector('.to-top');
    let ticking = false;

    const update = () => {
        const y = window.scrollY;

        if (header) header.classList.toggle('is-stuck', y > 24);
        if (toTop) toTop.classList.toggle('is-on', y > 640);

        if (progress) {
            const max = document.documentElement.scrollHeight - window.innerHeight;
            progress.style.width = max > 0 ? `${(y / max) * 100}%` : '0%';
        }

        ticking = false;
    };

    window.addEventListener(
        'scroll',
        () => {
            if (ticking) return;
            ticking = true;
            requestAnimationFrame(update);
        },
        { passive: true }
    );

    update();

    if (toTop) {
        toTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: reduceMotion ? 'auto' : 'smooth' });
        });
    }
}

/* ------------------------------------------------------------------
 * Hero parallax
 * ---------------------------------------------------------------- */
function initParallax() {
    const layers = document.querySelectorAll('[data-parallax]');
    if (!layers.length || reduceMotion) return;

    let ticking = false;
    const update = () => {
        const y = window.scrollY;
        layers.forEach((el) => {
            const speed = parseFloat(el.dataset.parallax || '0.15');
            el.style.transform = `translate3d(0, ${y * speed}px, 0)`;
        });
        ticking = false;
    };

    window.addEventListener(
        'scroll',
        () => {
            if (ticking) return;
            ticking = true;
            requestAnimationFrame(update);
        },
        { passive: true }
    );
    update();
}

/* ------------------------------------------------------------------
 * Close the mobile menu after a link is tapped
 * ---------------------------------------------------------------- */
function initMobileNav() {
    const collapse = document.getElementById('mainNav');
    if (!collapse) return;

    collapse.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => {
            if (!collapse.classList.contains('show')) return;
            bootstrap.Collapse.getOrCreateInstance(collapse).hide();
        });
    });
}

/* ------------------------------------------------------------------
 * Marquee — duplicate the content for a seamless loop
 * ---------------------------------------------------------------- */
function initMarquee() {
    document.querySelectorAll('.marquee-track').forEach((track) => {
        if (track.dataset.cloned === '1') return;
        track.innerHTML += track.innerHTML;
        track.dataset.cloned = '1';
    });
}

/* ------------------------------------------------------------------
 * Prevent double submits
 * ---------------------------------------------------------------- */
function initForms() {
    document.querySelectorAll('form[data-lock-submit]').forEach((form) => {
        form.addEventListener('submit', () => {
            const btn = form.querySelector('[type="submit"]');
            if (!btn || form.querySelector(':invalid')) return;
            btn.disabled = true;
            btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>${
                btn.dataset.loadingText || '…'
            }`;
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initMarquee();
    initReveal();
    initCounters();
    initScrollUi();
    initParallax();
    initMobileNav();
    initForms();
});
