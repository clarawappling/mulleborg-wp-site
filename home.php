<?php
/* Template Name: Home Page */
get_header(); 
?>

<?php if ( has_post_thumbnail() ) : ?>
    <div class="homepage-hero">
        <?php the_post_thumbnail('large', ['class' => 'homepage-banner']); ?>
        <div class="hero-overlay">
            <?php 
            $hero_link = get_field('hero_button_page');
            $hero_text = get_field('hero_button_text');
            ?>

            <?php if ($hero_link || $hero_text) : ?>
                <a href="<?php echo esc_url($hero_link); ?>" class="hero-btn">
                    <?php echo esc_html($hero_text); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

<!-- Intro Section -->
<?php 
$intro_title = get_field('intro_title');
$intro_text  = get_field('intro_text');
?>

<?php if ($intro_title || $intro_text) : ?>
<div class="section">
    <div class="section-divider divider-to-cream">
    <?php echo file_get_contents( get_template_directory() . '/assets/dividers/svgs/wave-top.svg' ); ?>
</div></div>
    <div class="flex intro">

    <?php if ($intro_title) : ?>
        <h1><?php echo esc_html($intro_title); ?></h1>
    <?php endif; ?>
    <?php if ($intro_text) : ?>
        <div><?php echo wp_kses_post($intro_text); ?></div>
    <?php endif; ?>
</div>
<?php endif; ?>
<div class="section">
    <div class="section-divider divider-to-cream">
    <?php echo file_get_contents( get_template_directory() . '/assets/dividers/svgs/wave-bottom.svg' ); ?>
</div></div>
<div class="sections-wrapper home">

<!-- Green Section -->
 
<?php 
$green_image = get_field('green_box_image');
$green_title = get_field('green_box_title');
$green_text  = get_field('green_box_text');
$green_btn_page = get_field('green_box_button_page');
$green_btn_text = get_field('green_box_button_text');
?>

<?php if ($green_image || $green_title || $green_text || $green_btn_page || $green_btn_text) : ?>
<div class="section-box">
    <?php if ($green_image) : ?>
        <div class="image-wrapper">
            <img src="<?php echo esc_url($green_image['url']); ?>" alt="<?php echo esc_attr($green_image['alt']); ?>">
  
        </div>

    <?php endif; ?>
<div class="section">
    <div class="section-divider divider-to-green">
    <?php echo file_get_contents( get_template_directory() . '/assets/dividers/svgs/scallop.svg' ); ?>
</div></div>
    <div class="flex green-bg info-box extended-height">
        
        <?php if ($green_title) : ?>
            <h1><?php echo esc_html($green_title); ?></h1>
        <?php endif; ?>

        <?php if ($green_text) : ?>
            <div><?php echo wp_kses_post($green_text); ?></div>
        <?php endif; ?>

        <?php if ($green_btn_page || $green_btn_text) : ?>
            <a href="<?php echo esc_url($green_btn_page); ?>" class="btn yellow-btn">
                <?php echo esc_html($green_btn_text); ?>
            </a>
        <?php endif; ?>
        
    </div>
</div>
<div class="section">
    <div class="section-divider divider-to-green">
    <?php echo file_get_contents( get_template_directory() . '/assets/dividers/svgs/wave-bottom.svg' ); ?>
</div></div>
<?php endif; ?>

<!-- Orange Section -->
<?php 
$orange_image = get_field('orange_box_image');
$orange_title = get_field('orange_box_title');
$orange_text  = get_field('orange_box_text');
$orange_btn_page = get_field('orange_box_button_page');
$orange_btn_text = get_field('orange_box_button_text');
?>

<?php if ($orange_image || $orange_title || $orange_text || $orange_btn_page || $orange_btn_text) : ?>
<div class="section-box">
    
    <?php if ($orange_image) : ?>
        <div class="image-wrapper">
            <img src="<?php echo esc_url($orange_image['url']); ?>" alt="<?php echo esc_attr($orange_image['alt']); ?>">
        </div>
    <?php endif; ?>
<div class="section">
    <div class="section-divider divider-to-orange">
    <?php echo file_get_contents( get_template_directory() . '/assets/dividers/svgs/wave-top.svg' ); ?>
</div></div>
    <div class="flex orange-bg info-box extended-height">
        <?php if ($orange_title) : ?>
            <h1><?php echo esc_html($orange_title); ?></h1>
        <?php endif; ?>

        <?php if ($orange_text) : ?>
            <div><?php echo wp_kses_post($orange_text); ?></div>
        <?php endif; ?>

        <?php if ($orange_btn_page || $orange_btn_text) : ?>
            <a href="<?php echo esc_url($orange_btn_page); ?>" class="btn green-btn">
                <?php echo esc_html($orange_btn_text); ?>
            </a>
        <?php endif; ?>
    </div>
</div>
<div class="section">
    <div class="section-divider divider-to-orange">
    <?php echo file_get_contents( get_template_directory() . '/assets/dividers/svgs/wave-bottom.svg' ); ?>
</div></div>
<?php endif; ?>

<!-- Yellow Section -->
<?php 
$yellow_image = get_field('yellow_box_image');
$yellow_title = get_field('yellow_box_title');
$yellow_text  = get_field('yellow_box_text');
?>

<?php if ($yellow_image || $yellow_title || $yellow_text) : ?>
<div class="section-box">
    <?php if ($yellow_image) : ?>
        <div class="image-wrapper">
            <img src="<?php echo esc_url($yellow_image['url']); ?>" alt="<?php echo esc_attr($yellow_image['alt']); ?>">
        </div>
    <?php endif; ?>
<div class="section">
    <div class="section-divider divider-to-yellow">
    <?php echo file_get_contents( get_template_directory() . '/assets/dividers/svgs/wave-top.svg' ); ?>
</div></div>
    <div class="flex yellow-bg info-box extended-height">
        <?php if ($yellow_title) : ?>
            <h1><?php echo esc_html($yellow_title); ?></h1>
        <?php endif; ?>

        <?php if ($yellow_text) : ?>
            <div><?php echo wp_kses_post($yellow_text); ?></div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

</div>
<?php get_footer(); ?>
