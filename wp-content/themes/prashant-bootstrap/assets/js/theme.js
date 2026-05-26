var prashantBootstrapInit = function () {
    var preloader = document.getElementById("site-preloader");
    var siteHeader = document.querySelector(".site-header");
    var readMoreToggles = document.querySelectorAll(".read-more-toggle");
    var revealItems = document.querySelectorAll("[data-reveal]");

    if (preloader) {
        var preloaderStartedAt = Date.now();
        var minimumPreloaderTime = 3000;

        var hidePreloader = function () {
            var elapsed = Date.now() - preloaderStartedAt;
            var remaining = Math.max(minimumPreloaderTime - elapsed, 0);

            window.setTimeout(function () {
                preloader.classList.add("is-hidden");
                window.setTimeout(function () {
                    if (preloader && preloader.parentNode) {
                        preloader.parentNode.removeChild(preloader);
                    }
                }, 700);
            }, remaining);
        };

        if (document.readyState === "complete") {
            hidePreloader();
        } else {
            window.addEventListener("load", function () {
                hidePreloader();
            });
            window.setTimeout(hidePreloader, 3200);
        }
    }

    if (!siteHeader) {
        siteHeader = null;
    }

    if (siteHeader) {
        var syncHeaderState = function () {
            if (window.scrollY > 18) {
                siteHeader.classList.add("is-scrolled");
            } else {
                siteHeader.classList.remove("is-scrolled");
            }
        };

        syncHeaderState();
        window.addEventListener("scroll", syncHeaderState, { passive: true });
    }

    readMoreToggles.forEach(function (toggle) {
        var targetSelector = toggle.getAttribute("data-bs-target");
        var target = targetSelector ? document.querySelector(targetSelector) : null;

        if (!target) {
            return;
        }

        target.addEventListener("shown.bs.collapse", function () {
            toggle.textContent = "Read Less";
        });

        target.addEventListener("hidden.bs.collapse", function () {
            toggle.textContent = "Read More";
        });
    });

    if (revealItems.length) {
        var revealObserver = new IntersectionObserver(
            function (entries, observer) {
                entries.forEach(function (entry) {
                    if (!entry.isIntersecting) {
                        return;
                    }

                    entry.target.classList.add("is-visible");
                    observer.unobserve(entry.target);
                });
            },
            {
                threshold: 0.14,
                rootMargin: "0px 0px -40px 0px"
            }
        );

        revealItems.forEach(function (item, index) {
            item.style.transitionDelay = Math.min(index * 60, 260) + "ms";
            revealObserver.observe(item);
        });
    }
};

if (document.readyState !== "loading") {
    prashantBootstrapInit();
} else {
    document.addEventListener("DOMContentLoaded", prashantBootstrapInit);
}

