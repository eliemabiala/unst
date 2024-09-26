let burger = document.querySelector(".burger");
let burgMenu = document.querySelector(".burg");

// Initialement, on cache le menu burger
burgMenu.style.display = "none";

burger.addEventListener('click', function () {
    // Toggle entre l'affichage et le masquage du menu
    if (burgMenu.style.display === "none") {
        burgMenu.style.display = "block";
    } else {
        burgMenu.style.display = "none";
    }
});