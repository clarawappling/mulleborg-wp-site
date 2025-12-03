document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('menu-toggle');
    const navMenu = document.querySelector('.main-navigation');

    menuToggle.addEventListener('click', function() {
        navMenu.classList.toggle('active');
        menuToggle.classList.toggle('active'); // animate hamburger

        // Toggle aria-expanded for accessibility
        const expanded = this.getAttribute('aria-expanded') === 'true' || false;
        this.setAttribute('aria-expanded', !expanded);
    });
});
