<!doctype html>
<html <?php language_attributes(); ?>>
<head>

<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
 <!-- Tell browser the site supports both modes -->
  <meta name="color-scheme" content="light dark">

  <!-- Optional: theme color for status bars -->
  <meta name="theme-color" content="#ffffff" media="(prefers-color-scheme: light)">
  <meta name="theme-color" content="#0f172a" media="(prefers-color-scheme: dark)">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<div id="page" class="hfeed site">

<header id="masthead" class="site-header">
<div class='header-inner'>    
<div class="site-branding">
        <?php
        if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
            echo '<div class="logo-wrapper">';
            the_custom_logo();
            echo '</div>';
        } else {
            // Fallback to site name if no logo is set
            echo '<h1 class="site-title"><a href="' . esc_url( home_url( '/' ) ) . '">' . get_bloginfo( 'name' ) . '</a></h1>';
        }
        ?>
    </div>
            
<!-- Hamburger button -->
<button id="menu-toggle" aria-controls="primary-menu" aria-expanded="false" aria-label="Open menu">
    <span class="bar"></span>
    <span class="bar"></span>
    <span class="bar"></span>
</button>

<nav id="site-navigation" class="main-navigation">
    <?php
    wp_nav_menu( array(
        'theme_location' => 'primary',
        'menu_id'        => 'primary-menu',
        'container'      => false,
    ) );
    ?>
</nav>

        </div>
</header>
<main id="main-content" class="site-content" tabindex="-1">
    <div class="col-full">