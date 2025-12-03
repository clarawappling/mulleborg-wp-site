<footer class="site-footer">
    <div class="footer-inner">

    <?php
    // Get the "Footer Settings" page
    $footer_page = get_page_by_title('Footer Settings');

    // Initialize variables with fallbacks
    $footerPhone      = '076-005 74 87';
    $footerAddress1   = 'Raketstigen 13';
    $footerAddress2   = '181 57 Lidingö';
    $footerCTA_Text   = 'Sök plats';
    $footerCTA_Link   = home_url('/'); // fallback to your contact page

    if ($footer_page) {
        $id = $footer_page->ID;

        // Get ACF fields from the "Footer Settings" page
        $footerPhone      = get_field('footer_phone', $id) ?: $footerPhone;
        $footerAddress1   = get_field('footer_address_line_1', $id) ?: $footerAddress1;
        $footerAddress2   = get_field('footer_address_line_2', $id) ?: $footerAddress2;
        $footerCTA_Text   = get_field('footer_cta_text', $id) ?: $footerCTA_Text;
        $footerCTA_Link   = get_field('footer_cta_page', $id) ?: $footerCTA_Link;
    }
    ?>

    <div id="footer-address">
        <h4>Address</h4>
        <p><?php echo esc_html($footerAddress1); ?></p>
        <p><?php echo esc_html($footerAddress2); ?></p>
    </div>

    <div id="footer-phone">
        <h4>Telefon</h4>
        <p><?php echo esc_html($footerPhone); ?></p>
    </div>

    <div>
        <a href="<?php echo esc_url($footerCTA_Link); ?>" class="btn footer-cta-btn">
            <?php echo esc_html($footerCTA_Text); ?>
        </a>
    </div>

    <div class="footer-column footer-nav">
        <?php
        if (has_nav_menu('footer')) {
            wp_nav_menu([
                'theme_location' => 'footer',
                'container'      => false,
                'menu_class'     => 'footer-nav',
            ]);
        }
        ?>
    </div>

    <div class="footer-column footer-copy">
        &copy; <?php echo date('Y'); ?> <?php echo esc_html(get_bloginfo('name')); ?>
    </div>

    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
