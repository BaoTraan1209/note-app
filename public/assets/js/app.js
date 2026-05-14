document.querySelectorAll("[data-password-toggle]").forEach((button) => {
    button.addEventListener("click", () => {
        const input = document.querySelector(`#${button.dataset.target}`);
        if (!input) return;

        const isPassword = input.type === "password";
        input.type = isPassword ? "text" : "password";
        button.setAttribute("aria-label", isPassword ? "Hide password" : "Show password");
        button.innerHTML = isPassword ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>';
    });
});

document.querySelectorAll("[data-loading-form]").forEach((form) => {
    form.addEventListener("submit", () => {
        const button = form.querySelector("button[type='submit']");
        if (!button) return;
        button.style.opacity = "0.82";
        button.style.pointerEvents = "none";
    });
});

const sidebarToggle = document.querySelector("[data-sidebar-toggle]");
sidebarToggle?.addEventListener("click", () => {
    document.body.classList.toggle("sidebar-open");
});

const userMenuButton = document.querySelector("[data-user-menu]");
const userDropdown = document.querySelector("[data-user-dropdown]");

userMenuButton?.addEventListener("click", (event) => {
    event.stopPropagation();
    userDropdown?.classList.toggle("is-open");
});

document.addEventListener("click", (event) => {
    if (!event.target.closest(".user-menu")) {
        userDropdown?.classList.remove("is-open");
    }

    if (
        document.body.classList.contains("sidebar-open") &&
        !event.target.closest(".sidebar") &&
        !event.target.closest("[data-sidebar-toggle]")
    ) {
        document.body.classList.remove("sidebar-open");
    }
});

const notesGrid = document.querySelector("[data-notes-grid]");
const noteCards = [...document.querySelectorAll("[data-note-card]")];
const noteSearch = document.querySelector("[data-note-search]");
const labelSelect = document.querySelector("[data-label-select]");
const emptyState = document.querySelector("[data-empty-state]");
let activeStatus = "all";

function applyNoteFilters() {
    if (!noteCards.length) return;

    const keyword = (noteSearch?.value || "").trim().toLowerCase();
    const activeLabel = labelSelect?.value || "all";
    let visible = 0;

    noteCards.forEach((card) => {
        const labels = (card.dataset.labels || "").split(" ").filter(Boolean);
        const statuses = (card.dataset.status || "").split(" ").filter(Boolean);
        const haystack = card.textContent.toLowerCase();
        const matchKeyword = !keyword || haystack.includes(keyword);
        const matchLabel = activeLabel === "all" || labels.includes(activeLabel);
        const matchStatus = activeStatus === "all" || statuses.includes(activeStatus);
        const shouldShow = matchKeyword && matchLabel && matchStatus;

        card.classList.toggle("is-hidden", !shouldShow);
        if (shouldShow) visible += 1;
    });

    emptyState?.classList.toggle("is-hidden", visible > 0);
}

noteSearch?.addEventListener("input", applyNoteFilters);
labelSelect?.addEventListener("change", applyNoteFilters);

document.querySelectorAll("[data-status-filter]").forEach((button) => {
    button.addEventListener("click", () => {
        document.querySelectorAll("[data-status-filter]").forEach((item) => item.classList.remove("active"));
        button.classList.add("active");
        activeStatus = button.dataset.statusFilter;
        applyNoteFilters();
    });
});

document.querySelectorAll("[data-label-filter]").forEach((button) => {
    button.addEventListener("click", () => {
        document.querySelectorAll("[data-label-filter]").forEach((item) => item.classList.remove("active"));
        button.classList.add("active");
        if (labelSelect) labelSelect.value = button.dataset.labelFilter;
        applyNoteFilters();
    });
});

document.querySelectorAll("[data-view]").forEach((button) => {
    button.addEventListener("click", () => {
        document.querySelectorAll("[data-view]").forEach((item) => item.classList.remove("active"));
        button.classList.add("active");
        notesGrid?.classList.toggle("list-view", button.dataset.view === "list");
    });
});
