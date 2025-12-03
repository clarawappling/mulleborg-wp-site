<?php
get_header(); ?>

<div class="staff-archive">
    <h1 class="no-margin"><?php post_type_archive_title(); ?></h1>

    <?php if ( have_posts() ) : ?>
        <div class="staff-grid">
            <?php while ( have_posts() ) : the_post(); ?>
                <div class="staff-member">
                    
                    <a href="<?php the_permalink(); ?>">
                        <div class="staff-photo">
                            <?php 
                            if ( has_post_thumbnail() ) {
                                the_post_thumbnail('large');
                            } else {
                                echo '<img src="' . get_template_directory_uri() . '/assets/images/Portrait_Placeholder.png" alt="Staff placeholder">';
                            }
                            ?>
                        </div>
                        <h2><?php the_title(); ?></h2>
                    </a>

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
                </div>
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
