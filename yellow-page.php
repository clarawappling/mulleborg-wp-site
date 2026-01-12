<?php
/* Template Name: Yellow Page */
get_header(); 
?>

<div class="yellow-page">
<div class=section-box>
<?php if ($yellow_page_image = get_field('yellow_page_image')) : ?>
        <div class="image-wrapper">
            <img src="<?php echo esc_url($yellow_page_image['url']); ?>" alt="<?php echo esc_attr($yellow_page_image['alt']); ?>">
        </div>
    <?php endif; ?>

<?php 
$yellow_page_heading = get_field('yellow_page_heading');
$yellow_page_text = get_field('yellow_page_text');

if ($yellow_page_heading  || $yellow_page_text) : ?>
<div class="section">
    <div class="section-divider divider-to-yellow">
    <?php echo file_get_contents( get_template_directory() . '/assets/dividers/svgs/wave-top.svg' ); ?>
</div></div>
    <div class="flex yellow-bg info-box">
        <?php if ($yellow_page_heading) : ?>
            <h1><?php echo esc_html($yellow_page_heading); ?></h1>
        <?php endif; ?>

        <?php if ($yellow_page_text) : ?>
            <div><?php echo wp_kses_post($yellow_page_text); ?></div>
        <?php endif; ?>
    </div>
    <div class="section">
    <div class="section-divider divider-to-yellow">
    <?php echo file_get_contents( get_template_directory() . '/assets/dividers/svgs/wave-bottom.svg' ); ?>
</div></div>
<?php endif; ?>
</div>
<div class=section-box>
<?php if ($yellow_page_image_2 = get_field('yellow_page_image_2')) : ?>
    <div class="image-wrapper">
        <img src="<?php echo esc_url($yellow_page_image_2['url']); ?>" alt="<?php echo esc_attr($yellow_page_image_2['alt']); ?>">
    </div>
<?php endif; ?>

<?php 
$yelllow_page_text_2 = get_field('yelllow_page_text_2');

if ($yelllow_page_text_2) : ?>
<div class="section">
    <div class="section-divider divider-to-yellow">
    <?php echo file_get_contents( get_template_directory() . '/assets/dividers/svgs/wave-top.svg' ); ?>
</div></div>
    <div class="flex yellow-bg info-box">
        <?php if ($yelllow_page_text_2) : ?>
            <div class="top-margin"><?php echo wp_kses_post($yelllow_page_text_2); ?></div>
        <?php endif; ?>
    </div> 
<?php endif; ?>

</div></div>
<?php get_footer(); ?>
