import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// Theme Logic
document.addEventListener("DOMContentLoaded", applyTheme);
document.addEventListener("livewire:navigated", applyTheme);
window.addEventListener("popstate", applyTheme);

function applyTheme() {
    const themeToggle = document.getElementById("theme-toggle");
    const themeToggleMobile = document.getElementById("theme-toggle-mobile");
    const themeToggleLight = document.getElementById("theme-toggle-light");
    const themeToggleDark = document.getElementById("theme-toggle-dark");

    function setTheme(mode) {
        if (mode === "dark") {
            document.documentElement.classList.add("dark");
            localStorage.setItem("theme", "dark");
            themeToggleLight?.classList.remove("hidden");
            themeToggleDark?.classList.add("hidden");
        } else {
            document.documentElement.classList.remove("dark");
            localStorage.setItem("theme", "light");
            themeToggleDark?.classList.remove("hidden");
            themeToggleLight?.classList.add("hidden");
        }
    }

    // Cek saved theme atau system preference
    const savedTheme = localStorage.getItem("theme");
    if (savedTheme) {
        setTheme(savedTheme);
    } else if (window.matchMedia("(prefers-color-scheme: dark)").matches) {
        setTheme("dark");
    } else {
        setTheme("light");
    }

    // Tambah event listener ke tombol Desktop (sekali saja)
    if (themeToggle && !themeToggle.dataset.listenerAdded) {
        themeToggle.addEventListener("click", () => {
            const isDark = document.documentElement.classList.contains("dark");
            setTheme(isDark ? "light" : "dark");
        });
        themeToggle.dataset.listenerAdded = "true";
    }

    // Tambah event listener ke tombol Mobile (sekali saja)
    if (themeToggleMobile && !themeToggleMobile.dataset.listenerAdded) {
        themeToggleMobile.addEventListener("click", () => {
            const isDark = document.documentElement.classList.contains("dark");
            setTheme(isDark ? "light" : "dark");
        });
        themeToggleMobile.dataset.listenerAdded = "true";
    }
}