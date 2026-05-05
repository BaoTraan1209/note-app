document.querySelectorAll(".password-toggle").forEach((button) => {
    button.addEventListener("click", () => {
        const target = document.querySelector(`#${button.dataset.target}`);
        if (!target) return;

        const isPassword = target.type === "password";
        target.type = isPassword ? "text" : "password";
        button.setAttribute("aria-label", isPassword ? "Hidden password" : "Show password");
        button.innerHTML = isPassword ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>';
    });
});

document.querySelectorAll("form").forEach((form) => {
    form.addEventListener("submit", () => {
        const button = form.querySelector(".auth-button");
        if (!button) return;
        button.style.opacity = "0.82";
        button.style.pointerEvents = "none";
    });
});
