<?php
/* Template Name: Home Page */
get_header(); 
?>

<?php if ( has_post_thumbnail() ) : ?>
    <div class="homepage-hero">
        <?php the_post_thumbnail('large', ['class' => 'homepage-banner']); ?>
        <div class="hero-overlay">
<?php 
$hero_link = get_field('hero_button_page') ?: '#';
$hero_text = get_field('hero_button_text') ?: 'SÖK PLATS';
?>

<a href="<?php echo esc_url($hero_link); ?>" class="hero-btn">
    <?php echo esc_html($hero_text); ?>
</a>

        </div>
    </div>
<?php endif; ?>

<!-- Intro Section -->
<div class="flex intro mobile">
   
    <h2><?php echo esc_html(get_field('intro_title') ?: 'Världens första I ur och skur-förskola'); ?></h2>

    <div>
        <?php echo wp_kses_post(get_field('intro_text') ?: 
        'På en stor kuperad naturtomt med kåta, snickarbod, vindskydd, kompost, höns och äppelträd hittar du förskolan Mulleborg.
        Vid de två intilliggande sjöarna paddlar vi på somrarna kanot - och åker skridskor på vintern.'); ?>
    </div>

</div>
<div class="sections-wrapper">
<!-- Green Section -->
<div class="section-box">
     <?php if ($green_image = get_field('green_box_image')) : ?>
        <div class="image-wrapper">
            <img src="<?php echo esc_url($green_image['url']); ?>" alt="<?php echo esc_attr($green_image['alt']); ?>">
        </div>
    <?php endif; ?>
<div class="flex green-bg info-box">
    <h2><?php echo esc_html(get_field('green_box_title')); ?></h2>
    <div>
        <?php echo wp_kses_post(get_field('green_box_text')); ?>
    </div>
<?php 
    $yellow_btn_link = get_field('green_box_button_page') ?: '#';
    $yellow_btn_text = get_field('green_box_button_text') ?: 'Läs mer';
?>

<a href="<?php echo esc_url($yellow_btn_link); ?>" class="btn yellow-btn">
    <?php echo esc_html($yellow_btn_text); ?>
</a>    

</div></div>

<!-- Orange Section -->
<div class="section-box">
     <?php if ($green_image = get_field('orange_box_image')) : ?>
        <div class="image-wrapper">
            <img src="<?php echo esc_url($green_image['url']); ?>" alt="<?php echo esc_attr($green_image['alt']); ?>">
        </div>
    <?php endif; ?>
<div class="flex orange-bg info-box">
    <h2><?php echo esc_html(get_field('orange_box_title')); ?></h2>
    <div>
        <?php echo wp_kses_post(get_field('orange_box_text')); ?>
    </div>
<?php 
$green_btn_link = get_field('orange_box_button_page') ?: '#';
$green_btn_text = get_field('orange_box_button_text') ?: 'Läs mer';
?>

<a href="<?php echo esc_url($green_btn_link); ?>" class="btn green-btn">
    <?php echo esc_html($green_btn_text); ?>
</a>    
</div></div>

<!-- Yellow Section -->
 <div class="section-box">
     <?php if ($green_image = get_field('yellow_box_image')) : ?>
        <div class="image-wrapper">
            <img src="<?php echo esc_url($green_image['url']); ?>" alt="<?php echo esc_attr($green_image['alt']); ?>">
        </div>
    <?php endif; ?>
<div class="flex yellow-bg info-box">
    <h2><?php echo esc_html(get_field('yellow_box_title')); ?></h2>
    <div>
        <?php echo wp_kses_post(get_field('yellow_box_text')); ?>
    </div>

</div></div></div>
<!-- Intro Section -->
<div class="flex intro desktop">
   
    <h2><?php echo esc_html(get_field('intro_title') ?: 'Världens första I ur och skur-förskola'); ?></h2>

    <div>
        <?php echo wp_kses_post(get_field('intro_text') ?: 
        'På en stor kuperad naturtomt med kåta, snickarbod, vindskydd, kompost, höns och äppelträd hittar du förskolan Mulleborg.
        Vid de två intilliggande sjöarna paddlar vi på somrarna kanot - och åker skridskor på vintern.'); ?>
    </div>

</div>

<?php get_footer(); ?>
