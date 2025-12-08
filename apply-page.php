<?php
/* Template Name: Apply Page */
get_header(); 

$apply_button_text = get_field('apply_button_text'); 
$external_apply_link = get_field('external_apply_link'); 
?>
<div class="sections-wrapper">
<?php if ($cooperative_page_image = get_field('apply_page_image')) : ?>
        <div class="image-wrapper">
            <img src="<?php echo esc_url($cooperative_page_image['url']); ?>" alt="<?php echo esc_attr($cooperative_page_image['alt']); ?>">
        </div>
    <?php endif; ?>
    <div class="flex info-box">
 <?php if ($heading = get_field('apply_page_heading')) : ?>
    <h2><?php echo esc_html($heading); ?></h2>
<?php endif; ?>

<?php if ($text = get_field('apply_page_text_section')) : ?>
    <div><?php echo wp_kses_post($text); ?></div>
<?php endif; ?>

 <?php if ($apply_button_text && $external_apply_link) : ?>
            <a href="<?php echo esc_url($external_apply_link); ?>" class="btn yellow-btn" target="_blank" rel="noopener">
                <?php echo esc_html($apply_button_text); ?>
            </a>
        <?php endif; ?>
</div>

</div>
<?php get_footer(); ?>