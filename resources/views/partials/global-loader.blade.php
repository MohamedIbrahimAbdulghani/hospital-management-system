{{-- Global Unified Page Loader for Hospital Management System --}}
<style>
    #global-loader {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
        background-color: #ffffff !important;
        z-index: 9999999 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        margin: 0 !important;
        padding: 0 !important;
        opacity: 1 !important;
        visibility: visible !important;
        transition: opacity 0.3s ease, visibility 0.3s ease !important;
        pointer-events: auto !important;
    }

    /* Support Dark Mode seamlessly */
    html.dark #global-loader,
    body.dark-theme #global-loader,
    .dark-theme #global-loader,
    .dark #global-loader,
    [data-theme="dark"] #global-loader {
        background-color: #0b1329 !important;
    }

    #global-loader .loader-img {
        width: 60px !important;
        height: 60px !important;
        max-width: 60px !important;
        max-height: 60px !important;
        position: static !important;
        margin: 0 auto !important;
        display: block !important;
        filter: drop-shadow(0 4px 14px rgba(1, 98, 232, 0.35));
    }

    #global-loader.loader-hidden {
        opacity: 0 !important;
        visibility: hidden !important;
        pointer-events: none !important;
    }
</style>

<div id="global-loader" style="position:fixed;top:0;left:0;right:0;bottom:0;width:100vw;height:100vh;background-color:#ffffff;z-index:9999999;display:flex;align-items:center;justify-content:center;" aria-label="Loading...">
    <img src="{{ URL::asset('Dashboard/img/loader.svg') }}" class="loader-img" alt="Loader">
</div>

<script>
    (function () {
        function getLoader() {
            return document.getElementById('global-loader');
        }

        var isNavigating = false;
        var navigationTimer = null;

        window.showGlobalLoader = function () {
            isNavigating = true;
            var loader = getLoader();
            if (loader) {
                loader.classList.remove('loader-hidden');
                loader.style.opacity = '1';
                loader.style.visibility = 'visible';
                loader.style.pointerEvents = 'auto';
            }

            // Extended safety fallback in case network or server freezes completely
            if (navigationTimer) clearTimeout(navigationTimer);
            navigationTimer = setTimeout(function () {
                isNavigating = false;
                window.hideGlobalLoader(true);
            }, 12000);
        };

        window.hideGlobalLoader = function (force) {
            if (isNavigating && !force) return;
            isNavigating = false;
            if (navigationTimer) {
                clearTimeout(navigationTimer);
                navigationTimer = null;
            }
            var loader = getLoader();
            if (!loader) return;
            loader.classList.add('loader-hidden');
            loader.style.pointerEvents = 'none';
        };

        // Hide loader when the page finishes loading
        function dismissInitialLoader() {
            isNavigating = false;
            setTimeout(function () {
                window.hideGlobalLoader(true);
            }, 180);
        }

        if (document.readyState === 'complete') {
            dismissInitialLoader();
        } else {
            window.addEventListener('load', dismissInitialLoader);
        }

        // BFCache support (Browser back/forward cache restore)
        window.addEventListener('pageshow', function (event) {
            if (event.persisted) {
                isNavigating = false;
                window.hideGlobalLoader(true);
            }
        });

        // Livewire navigation integration
        document.addEventListener('livewire:navigating', function () {
            window.showGlobalLoader();
        });
        document.addEventListener('livewire:navigated', function () {
            window.hideGlobalLoader(true);
        });

        // Show immediately on form submissions (login, register, role selection, admin actions)
        document.addEventListener('submit', function (e) {
            var form = e.target;
            if (!form) return;
            if (form.target && form.target === '_blank') return;
            if (typeof form.checkValidity === 'function' && !form.checkValidity()) return;
            window.showGlobalLoader();
        }, true);

        // Show on internal link clicks
        document.addEventListener('click', function (e) {
            var link = e.target.closest('a');
            if (!link) return;

            var href = link.getAttribute('href');
            if (!href) return;
            if (href.startsWith('#') || href.startsWith('javascript:') || href.startsWith('mailto:') || href.startsWith('tel:')) return;
            if (link.getAttribute('target') === '_blank') return;
            if (link.hasAttribute('download')) return;
            if (e.ctrlKey || e.metaKey || e.shiftKey || e.which === 2) return;

            try {
                var url = new URL(link.href, window.location.origin);
                if (url.origin === window.location.origin) {
                    if (url.pathname === window.location.pathname && url.search === window.location.search && url.hash !== '') {
                        return;
                    }
                    window.showGlobalLoader();
                }
            } catch (err) {}
        }, true);
    })();
</script>
