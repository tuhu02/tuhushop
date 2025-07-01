document.addEventListener("DOMContentLoaded", function () {
    const menuItems = document.querySelectorAll(".menu-item > a");

    menuItems.forEach(item => {
        item.addEventListener("click", function (e) {
            e.preventDefault(); // Cegah link default
            const submenu = this.nextElementSibling; // Ambil submenu terkait
            
            // Toggle hidden class
            if (submenu.classList.contains("hidden")) {
                submenu.classList.remove("hidden");
            } else {
                submenu.classList.add("hidden");
            }

            // Ganti ikon toggle
            const toggleIcon = this.querySelector(".toggle-icon");
            if (submenu.classList.contains("hidden")) {
                toggleIcon.classList.remove("fa-chevron-up");
                toggleIcon.classList.add("fa-chevron-down");
            } else {
                toggleIcon.classList.remove("fa-chevron-down");
                toggleIcon.classList.add("fa-chevron-up");
            }
        });
    });
});
