<?php
/* Template Name: Outdoors Page */
get_header(); 
?>
<div class="sections-wrapper">
<?php if ($outdoors_image = get_field('outdoors_image')) : ?>
        <div class="image-wrapper">
            <img src="<?php echo esc_url($outdoors_image['url']); ?>" alt="<?php echo esc_attr($outdoors_image['alt']); ?>">
        </div>
    <?php endif; ?>
    <div class="flex green-bg info-box">
    <h2><?php echo esc_html(get_field('outdoors_heading')); ?></h2>
    <div>
        <?php echo wp_kses_post(get_field('outdoors_text_section_1')); ?>
    </div>

</div>
<?php if ($outdoors_image_2 = get_field('outdoors_image_2')) : ?>
        <div class="image-wrapper">
            <img src="<?php echo esc_url($outdoors_image_2['url']); ?>" alt="<?php echo esc_attr($outdoors_image_2['alt']); ?>">
        </div>
    <?php endif; ?>
    <div class="flex green-bg info-box">
    <div class="top-margin">
        <?php echo wp_kses_post(get_field('outdoors_text_section_2')); ?>
    </div>
      <div><p>
        <?php echo wp_kses_post(get_field('outdoors_link_tip')); ?>
        </p>
        <p>
      <a class="ius_brand-color-text" href="<?php echo esc_url( get_field('i_ur_och_skur_link') ); ?>" target="_blank" rel="noopener">
            <?php echo esc_html( get_field('i_ur_och_skur_link') ); ?>
        </a>
        </p>
    </div>

</div>
</div>
<?php get_footer(); ?>