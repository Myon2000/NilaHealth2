document.addEventListener("DOMContentLoaded", function () {
    const themeToggle = document.getElementById("theme-toggle");
    const lightIcon = document.getElementById("theme-toggle-light");
    const darkIcon = document.getElementById("theme-toggle-dark");

    function setTheme(mode) {
        if (mode === "dark") {
            document.documentElement.classList.add("dark");
            localStorage.setItem("theme", "dark");
            lightIcon?.classList.remove("hidden");
            darkIcon?.classList.add("hidden");
        } else {
            document.documentElement.classList.remove("dark");
            localStorage.setItem("theme", "light");
            lightIcon?.classList.add("hidden");
            darkIcon?.classList.remove("hidden");
        }
    }

    const savedTheme = localStorage.getItem("theme");
    if (savedTheme === "dark" || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        setTheme("dark");
    } else {
        setTheme("light");
    }

    if (themeToggle) {
        themeToggle.addEventListener("click", () => {
            const isDark = document.documentElement.classList.contains("dark");
            setTheme(isDark ? "light" : "dark");
        });
    }
});