const form = document.querySelector("#loginForm");
const loginButton = document.querySelector(".login-button");
const toast = document.querySelector(".toast");
const password = document.querySelector("#password");
const toggle = document.querySelector(".password-toggle");

toggle.addEventListener("click", () => {
    const isPassword = password.type === "password";
    password.type = isPassword ? "text" : "password";
    toggle.setAttribute("aria-label", isPassword ? "Hidden password" : "Show password");
    toggle.innerHTML = isPassword ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>';
});

form.addEventListener("submit", () => {
    loginButton.classList.add("is-loading");
});

document.querySelectorAll(".social-button").forEach((button) => {
    button.addEventListener("click", () => {
        toast.querySelector("strong").textContent = "Dang nhap demo";
        toast.querySelector("span").textContent = `${button.textContent.trim()} se duoc gan voi OAuth trong Laravel.`;
        toast.classList.add("is-visible");
        window.setTimeout(() => toast.classList.remove("is-visible"), 3600);
    });
});
