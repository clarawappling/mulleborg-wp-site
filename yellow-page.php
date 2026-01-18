<?php
/* Template Name: Yellow Page */
get_header(); 
?>

<div class="yellow-page">

    <?php
    // FIELD VALUES
    $image_1   = get_field('yellow_page_image');
    $heading_1 = get_field('yellow_page_heading');
    $text_1    = get_field('yellow_page_text');

    $image_2 = get_field('yellow_page_image_2');
    $text_2  = get_field('yellow_page_text_2');

    $image_3 = get_field('yellow_page_image_3');
    $text_3  = get_field('yellow_page_text_3');

    $image_4 = get_field('yellow_page_image_4');
    $text_4  = get_field('yellow_page_text_4');
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
                    <div class="section-divider divider-to-yellow">
                        <?php echo file_get_contents(get_template_directory() . '/assets/dividers/svgs/wave-top.svg'); ?>
                    </div>
                </div>

                <div class="flex yellow-bg info-box">
                    <?php if ($heading_1) : ?>
                        <h1><?php echo esc_html($heading_1); ?></h1>
                    <?php endif; ?>

                    <?php if ($text_1) : ?>
                        <div><?php echo wp_kses_post($text_1); ?></div>
                    <?php endif; ?>
                </div>

                <?php if ($image_2 || $text_2 || $image_3 || $text_3 || $image_4 || $text_4) : ?>
                    <div class="section">
                        <div class="section-divider divider-to-yellow">
                            <?php echo file_get_contents(get_template_directory() . '/assets/dividers/svgs/wave-bottom.svg'); ?>
                        </div>
                    </div>
                <?php endif; ?>

            <?php endif; ?>

        </div>
    <?php endif; ?>


    <!-- SECTION 2 -->
    <?php if ($image_2 || $text_2) : ?>
        <div class="section-box">

            <?php if ($image_2) : ?>
                <div class="image-wrapper">
                    <img src="<?php echo esc_url($image_2['url']); ?>" alt="<?php echo esc_attr($image_2['alt']); ?>">
                </div>
            <?php endif; ?>

            <?php if ($text_2) : ?>
                <div class="section">
                    <div class="section-divider divider-to-yellow">
                        <?php echo file_get_contents(get_template_directory() . '/assets/dividers/svgs/wave-top.svg'); ?>
                    </div>
                </div>

                <div class="flex yellow-bg info-box">
                    <div class="top-margin">
                        <?php echo wp_kses_post($text_2); ?>
                    </div>
                </div>

                <?php if ($image_3 || $text_3 || $image_4 || $text_4) : ?>
                    <div class="section">
                        <div class="section-divider divider-to-yellow">
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
                    <div class="section-divider divider-to-yellow">
                        <?php echo file_get_contents(get_template_directory() . '/assets/dividers/svgs/wave-top.svg'); ?>
                    </div>
                </div>

                <div class="flex yellow-bg info-box">
                    <div class="top-margin">
                        <?php echo wp_kses_post($text_3); ?>
                    </div>
                </div>

                <?php if ($image_4 || $text_4) : ?>
                    <div class="section">
                        <div class="section-divider divider-to-yellow">
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
                    <div class="section-divider divider-to-yellow">
                        <?php echo file_get_contents(get_template_directory() . '/assets/dividers/svgs/wave-top.svg'); ?>
                    </div>
                </div>

                <div class="flex yellow-bg info-box">
                    <div class="top-margin">
                        <?php echo wp_kses_post($text_4); ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    <?php endif; ?>

</div>

<?php get_footer(); ?>
