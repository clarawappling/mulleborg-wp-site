<?php

// --------------------
// Theme Setup
// --------------------

function mulleborg_theme_setup() {
    // Let WordPress handle <title>
    add_theme_support('title-tag');

    // Support for menus
    add_theme_support('menus');

    // Register menus
    register_nav_menus([
        'primary' => __('Primary Menu', 'mulleborg'),
        'footer'  => __('Footer Menu', 'mulleborg'),
    ]);

    // Support for custom logo
    add_theme_support( 'custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ));
}
add_action('after_setup_theme', 'mulleborg_theme_setup');

// Enable featured images for posts AND pages
add_theme_support('post-thumbnails', ['post', 'page', 'staff']);

// --------------------
// Enqueue Styles & Scripts
// --------------------

function mulleborg_enqueue_assets() {
    wp_enqueue_style( 'mulleborg-style', get_stylesheet_uri() );
    wp_enqueue_script( 'mulleborg-script', get_template_directory_uri() . '/assets/js/main.js', array(), null, true );
}
add_action( 'wp_enqueue_scripts', 'mulleborg_enqueue_assets', 100 );

function mulleborg_enqueue_dashicons() {
    wp_enqueue_style( 'dashicons' );
}
add_action( 'wp_enqueue_scripts', 'mulleborg_enqueue_dashicons' );

// --------------------
// Custom Post Type: Staff
// --------------------
function mulleborg_register_cpt_staff() {

    $labels = array(
        'name'          => 'Personal',
        'singular_name' => 'Medarbetare',
        'add_new_item'  => 'Lägg till ny medarbetare',
        'edit_item'     => 'Redigera medarbetare',
        'all_items'     => 'All personal',
        'menu_name'     => 'Personal',
        'search_items'  => 'Sök personal',
        'not_found'     => 'Ingen personal hittades',
        'not_found_in_trash' => 'Ingen personal hittades i papperskorgen',
    );

    $args = array(
        'labels'       => $labels,
        'public'       => true,
        'menu_icon'    => 'dashicons-groups',
        'supports'     => array( 'title', 'thumbnail' ), // name + photo
        'show_in_rest' => false,
        'has_archive'  => true
    );

    register_post_type( 'staff', $args );
}
add_action( 'init', 'mulleborg_register_cpt_staff' );


// --------------------
// Job Title & Department Meta Boxes for Staff
// --------------------

function mulleborg_staff_meta_boxes() {
    // Job Title
    add_meta_box(
        'staff_job_title',
        'Yrkestitel', // Job Title
        'mulleborg_staff_job_title_callback',
        'staff',
        'normal',
        'high'
    );

    // Department
    add_meta_box(
        'staff_department',
        'Avdelning', // Department
        'mulleborg_staff_department_callback',
        'staff',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'mulleborg_staff_meta_boxes' );

// Job Title field
function mulleborg_staff_job_title_callback( $post ) {
    $value = get_post_meta( $post->ID, '_staff_job_title', true );
    echo '<input type="text" name="staff_job_title" value="' . esc_attr( $value ) . '" style="width:100%;" placeholder="t.ex. Barnskötare, Legitimerad Förskollärare. Lämna fältet tomt om ingen särskild roll eller utbildning ska nämnas.">';
}

// Department field
function mulleborg_staff_department_callback( $post ) {
    $value = get_post_meta( $post->ID, '_staff_department', true );
    echo '<input type="text" name="staff_department" value="' . esc_attr( $value ) . '" style="width:100%;" placeholder="t. ex. Mulle, Knytt eller Knopp">';
}

// Save both fields
function mulleborg_save_staff_meta( $post_id ) {
    if ( array_key_exists( 'staff_job_title', $_POST ) ) {
        update_post_meta(
            $post_id,
            '_staff_job_title',
            sanitize_text_field( $_POST['staff_job_title'] )
        );
    }
    if ( array_key_exists( 'staff_department', $_POST ) ) {
        update_post_meta(
            $post_id,
            '_staff_department',
            sanitize_text_field( $_POST['staff_department'] )
        );
    }
}
add_action( 'save_post', 'mulleborg_save_staff_meta' );


// --------------------
// Change title placeholder for Staff
// --------------------
function mulleborg_staff_title_placeholder( $title, $post ) {
    if ( $post->post_type === 'staff' ) {
        $title = 'Ange för- och efternamn';
    }
    return $title;
}
add_filter( 'enter_title_here', 'mulleborg_staff_title_placeholder', 10, 2 );
