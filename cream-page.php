<?php
/* Template Name: Cream Page */
get_header(); 
?>

<div class="cream-page">
<div class=section-box>
<?php if ($cream_page_image = get_field('cream_page_image')) : ?>
        <div class="image-wrapper">
            <img src="<?php echo esc_url($cream_page_image['url']); ?>" alt="<?php echo esc_attr($cream_page_image['alt']); ?>">
        </div>
    <?php endif; ?>

<?php 
$cream_page_heading = get_field('cream_page_heading');
$cream_page_text = get_field('cream_page_text');

if ($cream_page_heading  || $cream_page_text) : ?>
<div class="section">
    <div class="section-divider divider-to-cream">
    <?php echo file_get_contents( get_template_directory() . '/assets/dividers/svgs/wave-top.svg' ); ?>
</div></div>
    <div class="flex cream-bg info-box">
        <?php if ($cream_page_heading) : ?>
            <h1><?php echo esc_html($cream_page_heading); ?></h1>
        <?php endif; ?>

        <?php if ($cream_page_text) : ?>
            <div><?php echo wp_kses_post($cream_page_text); ?></div>
        <?php endif; ?>
    </div>
    <div class="section">
    <div class="section-divider divider-to-cream">
    <?php echo file_get_contents( get_template_directory() . '/assets/dividers/svgs/wave-bottom.svg' ); ?>
</div></div>
<?php endif; ?>
</div>
<div class=section-box>
<?php if ($cream_page_image_2 = get_field('cream_page_image_2')) : ?>
    <div class="image-wrapper">
        <img src="<?php echo esc_url($cream_page_image_2['url']); ?>" alt="<?php echo esc_attr($cream_page_image_2['alt']); ?>">
    </div>
<?php endif; ?>

<?php 
$cream_page_text_2 = get_field('cream_page_text_2');

if ($cream_page_text_2) : ?>
<div class="section">
    <div class="section-divider divider-to-cream">
    <?php echo file_get_contents( get_template_directory() . '/assets/dividers/svgs/wave-top.svg' ); ?>
</div></div>
    <div class="flex cream-bg info-box">
        <?php if ($cream_page_text_2) : ?>
            <div class="top-margin"><?php echo wp_kses_post($cream_page_text_2); ?></div>
        <?php endif; ?>
    </div> 
<?php endif; ?>

</div></div>
<?php get_footer(); ?>
