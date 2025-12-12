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

document.addEventListener('DOMContentLoaded', function() {

    const modal = document.getElementById('kidsModal');
    const sheet = document.querySelector('.kids-sheet');
    const openBtn = document.getElementById('openKidsModal');
    const closeBtn = document.querySelector('.kids-close');

    // open
    openBtn.addEventListener('click', () => {
        modal.style.display = 'flex';
        sheet.style.animation = "kidsSlideUp 0.33s ease-out forwards";
        document.body.style.overflow = "hidden"; // disable scrolling behind modal
    });

    // close
    function closeSheet() {
        sheet.style.animation = "kidsSlideDown 0.25s ease-in forwards";
        setTimeout(() => {
            modal.style.display = 'none';
            document.body.style.overflow = ""; 
        }, 250);
    }

    closeBtn.addEventListener('click', closeSheet);

    // close if clicking outside sheet
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeSheet();
        }
    });

});

