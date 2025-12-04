<?php
/* Template Name: Contact Page */
get_header(); 
?>
<div class="contact-wrapper">
<?php 
$contact_page_heading = get_field('contact_page_heading');
$contact_page_text_editor = get_field('contact_page_text_editor');
?>
<?php if ($contact_page_heading || $contact_page_text_editor ) :?>
<div>   
    <?php if ($contact_page_heading) : ?>
            <h1><?php echo esc_html($contact_page_heading); ?></h1>
        <?php endif; ?>
</div>  
<div>   
    <?php if ($contact_page_text_editor) : ?>
            <?php echo wp_kses_post($contact_page_text_editor); ?>
        <?php endif; ?>
    
</div> 
<?php endif; ?> 
</div> 
<?php get_footer(); ?>