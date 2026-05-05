const form = document.querySelector("#registerForm");
const registerButton = document.querySelector(".register-button");
const toast = document.querySelector(".toast");
const password = document.querySelector("#password");
const confirmPassword = document.querySelector("#password_confirmation");
const strength = document.querySelector(".strength");
const strengthText = document.querySelector(".strength-text");
const matchText = document.querySelector(".match-text");

const getStrength = (value) => {
    let score = 0;
    if (value.length >= 8) score += 1;
    if (/[A-Z]/.test(value)) score += 1;
    if (/[0-9]/.test(value)) score += 1;
    if (/[^A-Za-z0-9]/.test(value)) score += 1;
    return Math.max(1, score);
};

const updateStrength = () => {
    const level = getStrength(password.value);
    strength.dataset.level = level;
    const labels = ["yeu", "vua", "kha", "manh"];
    strengthText.textContent = `Do manh mat khau: ${labels[level - 1]}.`;
};

const updateMatch = () => {
    const matched = password.value && password.value === confirmPassword.value;
    matchText.textContent = matched ? "Mat khau da khop." : "Mat khau nhap lai chua khop.";
    matchText.classList.toggle("is-error", !matched);
    return matched;
};

document.querySelectorAll(".password-toggle").forEach((button) => {
    button.addEventListener("click", () => {
        const input = document.querySelector(`#${button.dataset.target}`);
        const isPassword = input.type === "password";
        input.type = isPassword ? "text" : "password";
        button.setAttribute("aria-label", isPassword ? "An mat khau" : "Hien mat khau");
        button.innerHTML = isPassword ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>';
    });
});

password.addEventListener("input", () => {
    updateStrength();
    updateMatch();
});
confirmPassword.addEventListener("input", updateMatch);

form.addEventListener("submit", (event) => {
    if (!updateMatch()) {
        event.preventDefault();
        return;
    }
    registerButton.classList.add("is-loading");
});

updateStrength();
updateMatch();
