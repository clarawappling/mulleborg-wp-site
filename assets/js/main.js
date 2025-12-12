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
    const contentDiv = document.querySelector('.kids-sheet-content');

    // open
    openBtn.addEventListener('click', () => {
        modal.style.display = 'flex';
        sheet.style.animation = "kidsSlideUp 0.33s ease-out forwards";
        document.body.style.overflow = "hidden";

        // If content not loaded yet, fetch via AJAX
        if (!contentDiv.dataset.loaded) {
            contentDiv.innerHTML = "⏳ Laddar väder och klädråd...";
            fetch(`${mulleborg_ajax.ajax_url}?action=get_kids_clothes`)
                .then(res => res.text())
                .then(html => {
                    contentDiv.innerHTML = html;
                    contentDiv.dataset.loaded = true; // prevent reloading
                })
                .catch(err => {
                    contentDiv.innerHTML = "<p>Väderfel: kunde inte hämta data.</p>";
                    console.error(err);
                });
        }
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



