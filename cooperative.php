<?php
/* Template Name: Cooperative Page */
get_header(); 
?>

<div class="cooperative-page">
<div class=section-box>
<?php if ($cooperative_page_image = get_field('cooperative_page_image')) : ?>
        <div class="image-wrapper">
            <img src="<?php echo esc_url($cooperative_page_image['url']); ?>" alt="<?php echo esc_attr($cooperative_page_image['alt']); ?>">
        </div>
    <?php endif; ?>

<?php 
$cooperative_heading = get_field('cooperative_page_heading');
$cooperative_text = get_field('cooperative_page_text');

if ($cooperative_heading || $cooperative_text) : ?>
<div class="section">
    <div class="section-divider divider-to-orange">
    <?php echo file_get_contents( get_template_directory() . '/assets/dividers/svgs/wave-top.svg' ); ?>
</div></div>
    <div class="flex orange-bg info-box">
        <?php if ($cooperative_heading) : ?>
            <h1><?php echo esc_html($cooperative_heading); ?></h1>
        <?php endif; ?>

        <?php if ($cooperative_text) : ?>
            <div><?php echo wp_kses_post($cooperative_text); ?></div>
        <?php endif; ?>
    </div>
    <div class="section">
    <div class="section-divider divider-to-orange">
    <?php echo file_get_contents( get_template_directory() . '/assets/dividers/svgs/wave-bottom.svg' ); ?>
</div></div>
<?php endif; ?>
</div>
<div class=section-box>
<?php if ($cooperative_page_image_2 = get_field('cooperative_page_image_2')) : ?>
    <div class="image-wrapper">
        <img src="<?php echo esc_url($cooperative_page_image_2['url']); ?>" alt="<?php echo esc_attr($cooperative_page_image_2['alt']); ?>">
    </div>
<?php endif; ?>

<?php 
$cooperative_page_text_2 = get_field('cooperative_page_text_2');

if ($cooperative_page_text_2) : ?>
<div class="section">
    <div class="section-divider divider-to-orange">
    <?php echo file_get_contents( get_template_directory() . '/assets/dividers/svgs/wave-top.svg' ); ?>
</div></div>
    <div class="flex orange-bg info-box">
        <?php if ($cooperative_page_text_2) : ?>
            <div class="top-margin"><?php echo wp_kses_post($cooperative_page_text_2); ?></div>
        <?php endif; ?>
    </div> 
<?php endif; ?>

</div></div>
<?php get_footer(); ?>
