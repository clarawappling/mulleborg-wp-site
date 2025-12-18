<?php
/* Template Name: Outdoors Page */
get_header(); 
?>
<div class="outdoors-page">
<div class=section-box>
<?php if ($outdoors_image = get_field('outdoors_image')) : ?>
    <div class="image-wrapper">
        <img src="<?php echo esc_url($outdoors_image['url']); ?>" alt="<?php echo esc_attr($outdoors_image['alt']); ?>">
    </div>
<?php endif; ?>

<?php 
$outdoors_heading = get_field('outdoors_heading');
$outdoors_text_1 = get_field('outdoors_text_section_1');

if ($outdoors_heading || $outdoors_text_1) : ?>
<div class="section">
    <div class="section-divider divider-to-green">
    <?php echo file_get_contents( get_template_directory() . '/assets/dividers/svgs/wave-top.svg' ); ?>
</div></div>
    <div class="flex green-bg info-box">
        <?php if ($outdoors_heading) : ?>
            <h1><?php echo esc_html($outdoors_heading); ?></h1>
        <?php endif; ?>

        <?php if ($outdoors_text_1) : ?>
            <div><?php echo wp_kses_post($outdoors_text_1); ?></div>
        <?php endif; ?>
    </div>
    <div class="section">
    <div class="section-divider divider-to-green">
    <?php echo file_get_contents( get_template_directory() . '/assets/dividers/svgs/wave-bottom.svg' ); ?>
</div></div>
<?php endif; ?>
</div>
<div class=section-box>
<?php if ($outdoors_image_2 = get_field('outdoors_image_2')) : ?>
    <div class="image-wrapper">
        <img src="<?php echo esc_url($outdoors_image_2['url']); ?>" alt="<?php echo esc_attr($outdoors_image_2['alt']); ?>">
    </div>
<?php endif; ?>

<?php 
$outdoors_text_2 = get_field('outdoors_text_section_2');
$outdoors_link_tip = get_field('outdoors_link_tip');
$i_ur_link = get_field('i_ur_och_skur_link');

if ($outdoors_text_2 || $outdoors_link_tip || $i_ur_link) : ?>
<div class="section">
    <div class="section-divider divider-to-green">
    <?php echo file_get_contents( get_template_directory() . '/assets/dividers/svgs/wave-top.svg' ); ?>
</div></div>
    <div class="flex green-bg info-box">
        <?php if ($outdoors_text_2) : ?>
            <div class="top-margin"><?php echo wp_kses_post($outdoors_text_2); ?></div>
        <?php endif; ?>

        <?php if ($outdoors_link_tip || $i_ur_link) : ?>
            <div>
                <?php if ($outdoors_link_tip) : ?>
                    <p><?php echo wp_kses_post($outdoors_link_tip); ?></p>
                <?php endif; ?>

                <?php if ($i_ur_link) : ?>
                    <p>
                        <a class="ius_brand-color-text" href="<?php echo esc_url($i_ur_link); ?>" target="_blank" rel="noopener">
                            <?php echo esc_html($i_ur_link); ?>
                        </a>
                    </p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div> 
<?php endif; ?>

</div></div>
<?php get_footer(); ?>
