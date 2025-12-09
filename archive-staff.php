<?php
get_header(); 
?>


    <?php 
    $settings_page = get_page_by_path('staff-archive-settings');
    $hero_image = $settings_page ? get_field('staff_archive_hero_image', $settings_page->ID) : null;
    $heading = $settings_page ? get_field('staff_archive_heading', $settings_page->ID) : null;
    $text_section = $settings_page ? get_field('staff_archive_text_section', $settings_page->ID) : null; ?>
    <div class="staff-hero-image-wrapper">
    <?php if ($hero_image) : ?>
            <img 
                src="<?php echo esc_url($hero_image['url']); ?>" 
                alt="<?php echo esc_attr($hero_image['alt']); ?>"
            > 
    <?php endif; ?>
    </div>
<div class="staff-archive">


         <?php if ($heading || $text_section) : ?> 
            <div class="info-box flex yellow-bg" id="staff-intro">
              <?php if ($heading) : ?>
            <h2><?php echo esc_html($heading); ?></h2>
        <?php endif; ?>
        <?php if ($text_section) : ?>
            <div><?php echo esc_html($text_section); ?></div>
        <?php endif; ?>

            </div>
            <?php endif; ?>
    <?php if ( have_posts() ) : ?>
        <div class="staff-grid">
   
            <?php while ( have_posts() ) : the_post(); ?>
                <div class="staff-member">

                        <div class="staff-image-wrapper">
                            <?php 
                            if ( has_post_thumbnail() ) {
                                the_post_thumbnail('small');
                            } else {
                                echo '<img src="' . get_template_directory_uri() . '/assets/images/Portrait_Placeholder.png" alt="Staff placeholder">';
                            }
                            ?>
                        </div>
                        <div class="staff-member-info">
                        <p class="staff-name"><?php the_title(); ?></p>
                   

                    <?php
                    $job_title = get_post_meta( get_the_ID(), '_staff_job_title', true );
                    if ( $job_title ) : ?>
                        <p class="staff-job-title"><?php echo esc_html( $job_title ); ?></p>
                    <?php endif; ?>

                    <?php
                    $department = get_post_meta( get_the_ID(), '_staff_department', true );
                    if ( $department ) : ?>
                        <p class="department-title"><?php echo esc_html( $department ); ?></p>
                    <?php endif; ?>
                </div> </div> 
            <?php endwhile; ?>
        </div>

        <?php
        // Pagination
        the_posts_pagination( array(
            'prev_text' => '← Föregående',
            'next_text' => 'Nästa →',
        ) );
        ?>

    <?php else : ?>
        <p>Ingen personal hittades.</p>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
