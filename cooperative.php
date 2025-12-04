<?php
/* Template Name: Cooperative Page */
get_header(); 
?>
<div class="sections-wrapper">
<?php if ($cooperative_page_image = get_field('cooperative_page_image')) : ?>
        <div class="image-wrapper">
            <img src="<?php echo esc_url($cooperative_page_image['url']); ?>" alt="<?php echo esc_attr($cooperative_page_image['alt']); ?>">
        </div>
    <?php endif; ?>
    <div class="flex orange-bg info-box">
 <?php if ($heading = get_field('cooperative_page_heading')) : ?>
    <h2><?php echo esc_html($heading); ?></h2>
<?php endif; ?>

<?php if ($text = get_field('cooperative_page_text')) : ?>
    <div><?php echo wp_kses_post($text); ?></div>
<?php endif; ?>
</div>
</div>
<?php get_footer(); ?>
