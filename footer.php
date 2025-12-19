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
        $footer_image    = $footer_id ? get_field('footer_image', $footer_id) : '';
        ?>

        <!-- Address Block -->
        <?php if ($footerAddress1 || $footerAddress2) : ?>
            <div id="footer-address">
                <h3>Address</h3>

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
                <h3>Telefon</h3>
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

   <!--- Footer illustration mobile -->     

<?php
if ( $footer_image ) :
?>
    <div class="footer-illustration">
        <img
            src="<?php echo esc_url( $footer_image['url'] ); ?>"
            alt="<?php echo esc_attr( $footer_image['alt'] ?: '' ); ?>"
            loading="lazy"
            width="<?php echo esc_attr( $footer_image['width'] ); ?>"
            height="<?php echo esc_attr( $footer_image['height'] ); ?>"
        >
    </div>
<?php endif; ?>


        <!-- Copyright -->
        <div class="footer-column footer-copy">
            &copy; <?php echo date('Y'); ?> <?php echo esc_html(get_bloginfo('name')); ?>
        </div>

    </div>

</footer>

<?php if ( get_theme_mod('kids_weather_enabled', true) ) : ?>
<div id="kidsModal" class="kids-fullscreen-overlay">
    <div class="kids-sheet">
        <span class="kids-close">✕</span>
        <div class="kids-sheet-content"></div>
    </div>
</div>

<button id="openKidsModal" class="kids-sticky-btn ius_dark_brand-color-background">
    <span class="kids-btn-icon">👕</span>
    <span class="kids-btn-text">
        Vad ska mitt barn ha på sig <?php echo mulleborg_get_day_label(); ?>?
    </span>
</button>

<?php endif; ?>


<?php wp_footer(); ?>

</body>
</html>
