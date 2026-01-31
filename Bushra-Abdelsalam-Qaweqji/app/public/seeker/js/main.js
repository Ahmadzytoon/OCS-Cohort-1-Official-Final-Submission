(function () {
    const navbar = document.querySelector(".cc-navbar");

    function onScroll() {
        if (!navbar) return;
        if (window.scrollY > 12) navbar.classList.add("cc-nav-scrolled");
        else navbar.classList.remove("cc-nav-scrolled");
    }

    // Smooth scroll for same-page anchor links
    function smoothAnchors() {
        document.querySelectorAll('a[href^="#"]').forEach((a) => {
            a.addEventListener("click", (e) => {
                const href = a.getAttribute("href");
                if (!href || href.length < 2) return;

                const target = document.querySelector(href);
                if (!target) return;

                e.preventDefault();
                const y =
                    target.getBoundingClientRect().top +
                    window.pageYOffset -
                    86; // offset for fixed navbar
                window.scrollTo({ top: y, behavior: "smooth" });
            });
        });
    }

    window.addEventListener("scroll", onScroll);
    window.addEventListener("load", () => {
        onScroll();
        smoothAnchors();
    });
})();

(function () {
    const page = document.getElementById("cleanersPage");
    if (!page) return;
})();

(function () {
    const timesWrap = document.getElementById("ccTimes");
    const bookBtn = document.getElementById("ccBookBtn");
    const dateInput = document.getElementById("ccDate");

    if (timesWrap) {
        timesWrap.addEventListener("click", (e) => {
            const btn = e.target.closest(".cc-time-btn");
            if (!btn) return;

            timesWrap
                .querySelectorAll(".cc-time-btn")
                .forEach((b) => b.classList.remove("active"));
            btn.classList.add("active");
        });
    }

    if (bookBtn) {
        bookBtn.addEventListener("click", () => {
            const activeTime = document.querySelector(".cc-time-btn.active");
            const time = activeTime
                ? activeTime.getAttribute("data-time")
                : "—";
            const date = dateInput ? dateInput.value : "";

            // Front-end only demo
            alert(
                `Booking request (demo)\nDate: ${date}\nTime: ${time}\nProvider: Maria Santos`,
            );
        });
    }
})();
(function () {
    const duration = document.getElementById("ccDuration");
    const hoursText = document.getElementById("ccHoursText");
    const totalText = document.getElementById("ccTotalText");
    if (!duration || !hoursText || !totalText) return;

    const rate = 35;
    const fee = 5;

    function update() {
        const h = Number(duration.value || 2);
        hoursText.textContent = String(h);
        totalText.textContent = String(rate * h + fee);
    }

    duration.addEventListener("change", update);
    update();
})();
(function () {
    document.addEventListener("click", (e) => {
        const btn = e.target.closest("[data-toggle-password]");
        if (!btn) return;

        const selector = btn.getAttribute("data-toggle-password");
        const input = document.querySelector(selector);
        if (!input) return;

        const isHidden = input.type === "password";
        input.type = isHidden ? "text" : "password";

        // optional: change icon
        btn.textContent = isHidden ? "🙈" : "👁";
    });
})();
