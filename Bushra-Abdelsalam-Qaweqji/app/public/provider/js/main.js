(function () {
    const sidebar = document.getElementById("ccSidebar");
    const toggle = document.getElementById("ccSidebarToggle");
    if (!sidebar || !toggle) return;

    toggle.addEventListener("click", () => {
        sidebar.classList.toggle("is-open");
    });

    document.addEventListener("click", (e) => {
        const isSmall = window.matchMedia("(max-width: 991.98px)").matches;
        if (!isSmall) return;

        const clickedInside =
            e.target.closest("#ccSidebar") ||
            e.target.closest("#ccSidebarToggle");
        if (!clickedInside) sidebar.classList.remove("is-open");
    });
})();
(function () {
    // Password toggle (generic)
    document.addEventListener("click", (e) => {
        const btn = e.target.closest("[data-toggle-password]");
        if (!btn) return;

        const selector = btn.getAttribute("data-toggle-password");
        const input = document.querySelector(selector);
        if (!input) return;

        const hidden = input.type === "password";
        input.type = hidden ? "text" : "password";
        btn.textContent = hidden ? "🙈" : "👁";
    });

    // Services: enable/disable Car fields
    const svcCar = document.getElementById("svcCar");
    if (svcCar) {
        const carPrice = document.getElementById("carPrice");
        const carDuration = document.getElementById("carDuration");
        const carNotes = document.getElementById("carNotes");
        const carSaveBtn = document.getElementById("carSaveBtn");

        function syncCar() {
            const on = svcCar.checked;
            [carPrice, carDuration, carNotes, carSaveBtn].forEach((el) => {
                if (el) el.disabled = !on;
            });
        }
        svcCar.addEventListener("change", syncCar);
        syncCar();
    }

    // Availability (MVP)
    const daysWrap = document.getElementById("ccDays");
    const selectedDayEl = document.getElementById("ccSelectedDay");
    const list = document.getElementById("ccSlotList");
    const addBtn = document.getElementById("ccAddSlot");

    // Simple in-memory slots (demo UI only)
    const slotsByDay = {
        Mon: [{ start: "09:00", end: "13:00" }],
        Tue: [{ start: "10:00", end: "14:00" }],
        Wed: [],
        Thu: [{ start: "09:00", end: "12:00" }],
        Fri: [{ start: "11:00", end: "15:00" }],
        Sat: [],
        Sun: [],
    };

    function renderDay(day) {
        if (!list) return;
        list.innerHTML = "";

        const slots = slotsByDay[day] || [];
        if (slots.length === 0) {
            const empty = document.createElement("div");
            empty.className = "text-muted small mb-2";
            empty.textContent = "No slots yet. Add your first time slot.";
            list.appendChild(empty);
            return;
        }

        slots.forEach((slot, idx) => {
            const row = document.createElement("div");
            row.className = "cc-slot";
            row.innerHTML = `
        <div class="flex-grow-1">
          <div class="row g-2">
            <div class="col-6">
              <label class="form-label small fw-semibold mb-1">Start</label>
              <input type="time" class="form-control cc-slot-start" value="${slot.start}">
            </div>
            <div class="col-6">
              <label class="form-label small fw-semibold mb-1">End</label>
              <input type="time" class="form-control cc-slot-end" value="${slot.end}">
            </div>
          </div>
        </div>
        <button type="button" class="btn btn-outline-danger cc-slot-remove" data-idx="${idx}">Remove</button>
      `;
            list.appendChild(row);

            // update in memory
            row.querySelector(".cc-slot-start").addEventListener(
                "change",
                (e) => {
                    slotsByDay[day][idx].start = e.target.value;
                },
            );
            row.querySelector(".cc-slot-end").addEventListener(
                "change",
                (e) => {
                    slotsByDay[day][idx].end = e.target.value;
                },
            );
            row.querySelector(".cc-slot-remove").addEventListener(
                "click",
                () => {
                    slotsByDay[day].splice(idx, 1);
                    renderDay(day);
                },
            );
        });
    }

    let currentDay = "Mon";

    if (daysWrap && selectedDayEl && list && addBtn) {
        renderDay(currentDay);

        daysWrap.addEventListener("click", (e) => {
            const btn = e.target.closest("[data-day]");
            if (!btn) return;

            daysWrap
                .querySelectorAll("[data-day]")
                .forEach((b) => b.classList.remove("active"));
            btn.classList.add("active");

            currentDay = btn.getAttribute("data-day");
            selectedDayEl.textContent = currentDay;
            renderDay(currentDay);
        });

        addBtn.addEventListener("click", () => {
            slotsByDay[currentDay] = slotsByDay[currentDay] || [];
            slotsByDay[currentDay].push({ start: "09:00", end: "11:00" });
            renderDay(currentDay);
        });
    }
})();
