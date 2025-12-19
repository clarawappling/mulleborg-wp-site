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

document.addEventListener('DOMContentLoaded', () => {

    // ---- WEATHER MODAL LOGIC ----
    const modal = document.getElementById('kidsModal');
    const sheet = document.querySelector('.kids-sheet');
    const openBtn = document.getElementById('openKidsModal');
    const closeBtn = document.querySelector('.kids-close');
    const contentDiv = document.querySelector('.kids-sheet-content');

    // Only run if the elements exist and AJAX object is defined
    if (!openBtn || !sheet || !modal || !closeBtn || !contentDiv || typeof mulleborg_ajax === 'undefined') {
        return; // exit early if weather button is disabled
    }

    /* --------------------------------
       SCROLL → COMPACT BUTTON LOGIC
    ---------------------------------- */
const SCROLL_TRIGGER = 150;
let isScrolled = false;

window.addEventListener('scroll', () => {
    if (window.scrollY > SCROLL_TRIGGER && !isScrolled) {
        openBtn.classList.add('is-scrolled');
        isScrolled = true;
    } else if (window.scrollY <= SCROLL_TRIGGER && isScrolled) {
        openBtn.classList.remove('is-scrolled');
        isScrolled = false;
    }
});


    /* --------------------------------
       MODAL OPEN
    ---------------------------------- */

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

    /* --------------------------------
       MODAL CLOSE
    ---------------------------------- */

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


    /* --------------------------------
       HEADER SCROLL
    ---------------------------------- */
window.addEventListener('scroll', function() {
    const header = document.querySelector('.header-inner');
    if(window.scrollY > 20){
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
});
