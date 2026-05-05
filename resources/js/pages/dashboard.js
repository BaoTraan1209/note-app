const grid = document.querySelector("#notesGrid");
const cards = [...document.querySelectorAll(".note-card")];
const search = document.querySelector("#noteSearch");
const labelSelect = document.querySelector("#labelSelect");
const emptyState = document.querySelector("#emptyState");
const toast = document.querySelector("#toast");
let statusFilter = "all";

const showToast = (message) => {
    toast.querySelector("span").textContent = message;
    toast.classList.add("is-visible");
    window.clearTimeout(showToast.timer);
    showToast.timer = window.setTimeout(() => toast.classList.remove("is-visible"), 2200);
};

const applyFilters = () => {
    const keyword = search.value.trim().toLowerCase();
    const label = labelSelect.value;
    let visible = 0;

    cards.forEach((card) => {
        const haystack = card.textContent.toLowerCase();
        const labels = card.dataset.labels.split(" ");
        const statuses = card.dataset.status.split(" ").filter(Boolean);
        const matchKeyword = !keyword || haystack.includes(keyword);
        const matchLabel = label === "all" || labels.includes(label);
        const matchStatus = statusFilter === "all" || statuses.includes(statusFilter);
        const shouldShow = matchKeyword && matchLabel && matchStatus;
        card.classList.toggle("is-hidden", !shouldShow);
        if (shouldShow) visible += 1;
    });

    emptyState.classList.toggle("is-visible", visible === 0);
};

document.querySelectorAll("[data-view]").forEach((button) => {
    button.addEventListener("click", () => {
        document.querySelectorAll("[data-view]").forEach((item) => item.classList.remove("active"));
        button.classList.add("active");
        grid.classList.toggle("list-view", button.dataset.view === "list");
        showToast(button.dataset.view === "list" ? "List view enabled." : "Grid view enabled.");
    });
});

document.querySelectorAll("[data-filter]").forEach((button) => {
    button.addEventListener("click", () => {
        document.querySelectorAll("[data-filter]").forEach((item) => item.classList.remove("active"));
        button.classList.add("active");
        statusFilter = button.dataset.filter;
        applyFilters();
    });
});

document.querySelectorAll("[data-label]").forEach((button) => {
    button.addEventListener("click", () => {
        document.querySelectorAll("[data-label]").forEach((item) => item.classList.remove("active"));
        button.classList.add("active");
        labelSelect.value = button.dataset.label;
        applyFilters();
    });
});

search.addEventListener("input", applyFilters);
labelSelect.addEventListener("change", applyFilters);

document.querySelector("[data-action='new-note']").addEventListener("click", () => {
    showToast("New note action ready for Laravel route.");
});

document.addEventListener("click", (event) => {
    const mini = event.target.closest(".mini-btn");
    if (!mini) return;
    showToast("Note action clicked.");
});
