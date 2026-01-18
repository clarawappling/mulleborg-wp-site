<?php
/* Template Name: Outdoors Page */
get_header(); 
?>

<div class="outdoors-page">

    <?php
    // FIELD VALUES
    $image_1   = get_field('outdoors_image');
    $heading_1 = get_field('outdoors_heading');
    $text_1    = get_field('outdoors_text_section_1');

    $image_2 = get_field('outdoors_image_2');
    $text_2  = get_field('outdoors_text_section_2');
    $link_tip = get_field('outdoors_link_tip');
    $ur_link  = get_field('i_ur_och_skur_link');

    $image_3 = get_field('outdoors_image_3');
    $text_3  = get_field('outdoors_text_section_3');

    $image_4 = get_field('outdoors_image_4');
    $text_4  = get_field('outdoors_text_section_4');
    ?>

    <!-- SECTION 1 -->
    <?php if ($image_1 || $heading_1 || $text_1) : ?>
        <div class="section-box">

            <?php if ($image_1) : ?>
                <div class="image-wrapper">
                    <img src="<?php echo esc_url($image_1['url']); ?>" alt="<?php echo esc_attr($image_1['alt']); ?>">
                </div>
            <?php endif; ?>

            <?php if ($heading_1 || $text_1) : ?>
                <div class="section">
                    <div class="section-divider divider-to-green">
                        <?php echo file_get_contents(get_template_directory() . '/assets/dividers/svgs/wave-top.svg'); ?>
                    </div>
                </div>

                <div class="flex green-bg info-box">
                    <?php if ($heading_1) : ?>
                        <h1><?php echo esc_html($heading_1); ?></h1>
                    <?php endif; ?>

                    <?php if ($text_1) : ?>
                        <div><?php echo wp_kses_post($text_1); ?></div>
                    <?php endif; ?>
                </div>

                <?php if ($image_2 || $text_2 || $link_tip || $ur_link || $image_3 || $text_3 || $image_4 || $text_4) : ?>
                    <div class="section">
                        <div class="section-divider divider-to-green">
                            <?php echo file_get_contents(get_template_directory() . '/assets/dividers/svgs/wave-bottom.svg'); ?>
                        </div>
                    </div>
                <?php endif; ?>

            <?php endif; ?>

        </div>
    <?php endif; ?>


    <!-- SECTION 2 -->
    <?php if ($image_2 || $text_2 || $link_tip || $ur_link) : ?>
        <div class="section-box">

            <?php if ($image_2) : ?>
                <div class="image-wrapper">
                    <img src="<?php echo esc_url($image_2['url']); ?>" alt="<?php echo esc_attr($image_2['alt']); ?>">
                </div>
            <?php endif; ?>

            <?php if ($text_2 || $link_tip || $ur_link) : ?>
                <div class="section">
                    <div class="section-divider divider-to-green">
                        <?php echo file_get_contents(get_template_directory() . '/assets/dividers/svgs/wave-top.svg'); ?>
                    </div>
                </div>

                <div class="flex green-bg info-box">

                    <?php if ($text_2) : ?>
                        <div class="top-margin"><?php echo wp_kses_post($text_2); ?></div>
                    <?php endif; ?>

                    <?php if ($link_tip || $ur_link) : ?>
                        <div>
                            <?php if ($link_tip) : ?>
                                <p><?php echo wp_kses_post($link_tip); ?></p>
                            <?php endif; ?>

                            <?php if ($ur_link) : ?>
                                <p>
                                    <a class="ius_brand-color-text"
                                       href="<?php echo esc_url($ur_link); ?>"
                                       target="_blank"
                                       rel="noopener">
                                        <?php echo esc_html($ur_link); ?>
                                    </a>
                                </p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                </div>

                <?php if ($image_3 || $text_3 || $image_4 || $text_4) : ?>
                    <div class="section">
                        <div class="section-divider divider-to-green">
                            <?php echo file_get_contents(get_template_directory() . '/assets/dividers/svgs/wave-bottom.svg'); ?>
                        </div>
                    </div>
                <?php endif; ?>

            <?php endif; ?>

        </div>
    <?php endif; ?>


    <!-- SECTION 3 -->
    <?php if ($image_3 || $text_3) : ?>
        <div class="section-box">

            <?php if ($image_3) : ?>
                <div class="image-wrapper">
                    <img src="<?php echo esc_url($image_3['url']); ?>" alt="<?php echo esc_attr($image_3['alt']); ?>">
                </div>
            <?php endif; ?>

            <?php if ($text_3) : ?>
                <div class="section">
                    <div class="section-divider divider-to-green">
                        <?php echo file_get_contents(get_template_directory() . '/assets/dividers/svgs/wave-top.svg'); ?>
                    </div>
                </div>

                <div class="flex green-bg info-box">
                    <div class="top-margin">
                        <?php echo wp_kses_post($text_3); ?>
                    </div>
                </div>

                <?php if ($image_4 || $text_4) : ?>
                    <div class="section">
                        <div class="section-divider divider-to-green">
                            <?php echo file_get_contents(get_template_directory() . '/assets/dividers/svgs/wave-bottom.svg'); ?>
                        </div>
                    </div>
                <?php endif; ?>

            <?php endif; ?>

        </div>
    <?php endif; ?>


    <!-- SECTION 4 -->
    <?php if ($image_4 || $text_4) : ?>
        <div class="section-box">

            <?php if ($image_4) : ?>
                <div class="image-wrapper">
                    <img src="<?php echo esc_url($image_4['url']); ?>" alt="<?php echo esc_attr($image_4['alt']); ?>">
                </div>
            <?php endif; ?>

            <?php if ($text_4) : ?>
                <div class="section">
                    <div class="section-divider divider-to-green">
                        <?php echo file_get_contents(get_template_directory() . '/assets/dividers/svgs/wave-top.svg'); ?>
                    </div>
                </div>

                <div class="flex green-bg info-box">
                    <div class="top-margin">
                        <?php echo wp_kses_post($text_4); ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    <?php endif; ?>

</div>

<?php get_footer(); ?>
