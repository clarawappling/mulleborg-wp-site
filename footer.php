<footer class="site-footer">
    <div class="footer-inner">

        <?php
        // Get the "Footer Settings" page by title
        $footer_page = get_page_by_title('Footer Settings');
        $footer_id   = $footer_page ? $footer_page->ID : null;

        // Get fields cleanly (no fallbacks)
        $footerPhone     = $footer_id ? get_field('footer_phone', $footer_id) : '';
        $footerAddress1  = $footer_id ? get_field('footer_address_line_1', $footer_id) : '';
        $footerAddress2  = $footer_id ? get_field('footer_address_line_2', $footer_id) : '';
        $footerCTA_Text  = $footer_id ? get_field('footer_cta_text', $footer_id) : '';
        $footerCTA_Link  = $footer_id ? get_field('footer_cta_page', $footer_id) : '';
        ?>

        <!-- Address Block -->
        <?php if ($footerAddress1 || $footerAddress2) : ?>
            <div id="footer-address">
                <h4>Address</h4>

                <?php if ($footerAddress1) : ?>
                    <p><?php echo esc_html($footerAddress1); ?></p>
                <?php endif; ?>

                <?php if ($footerAddress2) : ?>
                    <p><?php echo esc_html($footerAddress2); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>


        <!-- Phone Block -->
        <?php if ($footerPhone) : ?>
            <div id="footer-phone">
                <h4>Telefon</h4>
                <p><?php echo esc_html($footerPhone); ?></p>
            </div>
        <?php endif; ?>


        <!-- CTA Button -->
        <?php if ($footerCTA_Text && $footerCTA_Link) : ?>
            <div>
                <a href="<?php echo esc_url($footerCTA_Link); ?>" class="btn footer-cta-btn">
                    <?php echo esc_html($footerCTA_Text); ?>
                </a>
            </div>
        <?php endif; ?>


        <!-- Footer Menu -->
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

        <!-- Copyright -->
        <div class="footer-column footer-copy">
            &copy; <?php echo date('Y'); ?> <?php echo esc_html(get_bloginfo('name')); ?>
        </div>

    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
