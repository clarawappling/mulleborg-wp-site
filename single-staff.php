<?php
get_header(); ?>

<div class="staff-single">
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) : the_post(); ?>

            <h1><?php the_title(); ?></h1>

         <div class="staff-photo">
    <?php 
    if ( has_post_thumbnail() ) {
        the_post_thumbnail('large');
    } else {
        echo '<img src="' . get_template_directory_uri() . '/assets/images/Portrait_Placeholder.png" alt="Staff placeholder">';
    }
    ?>
</div>
            <?php
            $job_title = get_post_meta( get_the_ID(), '_staff_job_title', true );
            if ( $job_title ) : ?>
                <p class="staff-job-title"><?php echo esc_html( $job_title ); ?></p>
            <?php endif; ?>
             <?php
            $department = get_post_meta( get_the_ID(), '_staff_department', true );
            if ( $department) : ?>
                <p class="department-title"><?php echo esc_html( $department ); ?></p>
            <?php endif; ?>

            <div class="staff-content">
                <?php the_content(); ?>
            </div>

        <?php endwhile;
    endif;
    ?>
</div>

<?php get_footer(); ?>
