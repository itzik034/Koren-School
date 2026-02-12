const passInput = document.getElementById("l_pass");
const eyeOpen = document.getElementById("eyeOpen");
const eyeClosed = document.getElementById("eyeClosed");

eyeOpen.addEventListener("click", () => {
    passInput.type = "text";
    eyeOpen.classList.add("hidden");
    eyeClosed.classList.remove("hidden");
});

eyeClosed.addEventListener("click", () => {
    passInput.type = "password";
    eyeClosed.classList.add("hidden");
    eyeOpen.classList.remove("hidden");
});
