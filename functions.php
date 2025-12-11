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

// --------------------
// API Integration for weather data
// --------------------

// [test_weather] — basic Open-Meteo call
// add_shortcode('test_weather', function() {

//     // Example location — replace with your preschool's coords
//     $lat = 59.354625932401774;
//     $lon = 18.167468192093725;

//     // Simple Open-Meteo forecast API call
//     $url = add_query_arg(array(
//         'latitude' => $lat,
//         'longitude' => $lon,
//         'current_weather' => 'true'
//     ), 'https://api.open-meteo.com/v1/forecast');

//     $response = wp_remote_get($url, array('timeout'=>10));

//     if (is_wp_error($response)) {
//         return '<p>Weather error: could not connect.</p>';
//     }

//     $body = wp_remote_retrieve_body($response);
//     $data = json_decode($body, true);

//     if (empty($data) || !isset($data['current_weather']['temperature'])) {
//         return '<p>Weather error: data missing.</p>';
//     }

//     $temp = $data['current_weather']['temperature'];
    

//     // SUPER basic output
//     return "<p>Current temperature: <strong>{$temp}°C</strong></p>";
// });



add_shortcode('kids_clothes_categories_icons', function() {

    // 1️⃣ Bestäm idag/imorgon
    $current_hour = (int) current_time('H');
    if ($current_hour >= 17) {
        $day = 'imorgon';
        $index = 1;
    } else {
        $day = 'idag';
        $index = 0;
    }

    // 2️⃣ Hämta Open-Meteo daglig prognos
    $lat = 59.354625932401774;
    $lon = 18.167468192093725;

    $url = add_query_arg(array(
        'latitude' => $lat,
        'longitude' => $lon,
        'daily' => 'temperature_2m_max,temperature_2m_min,precipitation_sum,windspeed_10m_max',
        'timezone' => 'auto'
    ), 'https://api.open-meteo.com/v1/forecast');

    $response = wp_remote_get($url, array('timeout' => 10));
    if (is_wp_error($response)) return "<p>Väderfel: kunde inte ansluta.</p>";

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    if (empty($data['daily'])) return "<p>Väderfel: prognos saknas.</p>";

    // 3️⃣ Hämta dagliga värden
    $max_temp = $data['daily']['temperature_2m_max'][$index];
    $temp = $data['daily']['temperature_2m_min'][$index];
    $precip   = $data['daily']['precipitation_sum'][$index];
    $wind_kmh = $data['daily']['windspeed_10m_max'][$index];
    $wind_m_s = round($wind_kmh / 3.6, 1);
    $feels_like = $temp - ($wind_m_s * 1);

    // 4️⃣ Klädkategorier med logik
//TESTDATA
$temp = 9;
$precip = 10;
//SKOR 

$shoesRecommendation = "";

// Rain / wet conditions (rubber boots logic)
if ($precip > 1 && $temp >= 0) {

    if ($temp >= 7) {
        $shoesRecommendation = "Gummistövlar";
    } elseif ($temp >= 4) {
        $shoesRecommendation = "Gummistövlar. Fodrade eller med ullstrumpor i.";
    } else { // 0–3°C
        $shoesRecommendation = "Fodrade gummistövlar med ullstrumpor i.";
    }

}
// Dry conditions (temperature logic)
else {

    if ($temp >= 23) {
        $shoesRecommendation = "Svala skor, gärna sandaler. Idag är vi nog barfota en del.";
    } elseif ($temp >= 17) {
        $shoesRecommendation = "Gympaskor eller sandaler för tår som gärna vill spreta.";
    } elseif ($temp >= 10) {
        $shoesRecommendation = "Gympaskor.";
    } elseif ($temp >= 5) {
        $shoesRecommendation = "Kängor eller andra lite rejälare skor.";
    } elseif ($temp >= 3) {
        $shoesRecommendation = "Kängor eller vinterskor.";
    } elseif ($temp >= 0) {
        $shoesRecommendation = "Kängor eller vinterskor. Gärna ullstrumpor.";
    } elseif ($temp >= -5) {
        $shoesRecommendation = "Fodrade vinterskor och ullstrumpor.";
    } else { // Below -5
        $shoesRecommendation = "Fodrade vinterskor och dubbla ullstrumpor.";
    }

}


// KROPPEN
$innerWearRecommendation = "";
$outerWearRecommendation = "";

if ($precip <= 0) { // Dry conditions
    if ($temp >= 23) {
        $innerWearRecommendation = "Shorts och linne, eller liknande riktigt svala kläder.";
        $outerWearRecommendation = "";
    } elseif ($temp >= 20) {
        $innerWearRecommendation = "Shorts eller långbyxor, t-shirt eller linne.";
        $outerWearRecommendation = "";
    } elseif ($temp >= 17) {
        $innerWearRecommendation = "Långbyxor och kort- eller långärmad tröja.";
        $outerWearRecommendation = "";
    } elseif ($temp >= 14) {
        $innerWearRecommendation = "Långbyxor. T-shirt och skjorta eller collegetröja.";
        $outerWearRecommendation = "";
    } elseif ($temp >= 10) {
        $innerWearRecommendation = "Långbyxor. T-shirt och collegetröja eller skjorta.";
        $outerWearRecommendation = "Tunn jacka";
    } elseif ($temp >= 5) {
        $innerWearRecommendation = "Långbyxor eller underställsbyxor. Lager på lager på överkroppen, t.ex. underställströja och skjorta eller collegetröja.";
        $outerWearRecommendation = "Skaljacka och skalbyxor";
    } elseif ($temp >= 0) {
        $innerWearRecommendation = "Ullunderställ på under- och överkropp. Skjorta eller collegetröja.";
        $outerWearRecommendation = "Fodrad jacka. Skalbyxor eller fodrade.";
    } elseif ($temp >= -5) {
        $innerWearRecommendation = "Ullunderställ på under- och överkropp. Mellanlager, skjorta eller t-shirt. Därefter en varm tröja.";
        $outerWearRecommendation = "Fodrad jacka och täckbyxor";
    } else {
        $innerWearRecommendation = "Ullunderställ på under- och överkropp. Mellanlager, skjorta eller t-shirt. Därefter en ulltröja.";
        $outerWearRecommendation = "Fodrad jacka och täckbyxor";
    }
} 
else { // Wet conditions
    if ($temp >= 23) {
        $innerWearRecommendation = "Shorts och linne, eller liknande riktigt svala kläder.";
        $outerWearRecommendation = "Tunn regnjacka";
    } elseif ($temp >= 20) {
        $innerWearRecommendation = "Shorts eller långbyxor, t-shirt eller linne.";
        $outerWearRecommendation = "Regnjacka och regnbyxor";
    } elseif ($temp >= 17) {
        $innerWearRecommendation = "Långbyxor och kort- eller långärmad tröja.";
        $outerWearRecommendation = "Regnjacka och regnbyxor";
    } elseif ($temp >= 14) {
        $innerWearRecommendation = "Långbyxor. T-shirt och skjorta eller collegetröja.";
        $outerWearRecommendation = "Regnjacka och regnbyxor";
    } elseif ($temp >= 10) {
        $innerWearRecommendation = "Långbyxor. T-shirt och collegetröja eller skjorta.";
        $outerWearRecommendation = "Regnjacka och regnbyxor";
    } elseif ($temp >= 5) {
        $innerWearRecommendation = "Långbyxor eller underställsbyxor. Lager på lager på överkroppen, t.ex. underställströja och skjorta eller collegetröja.";
        $outerWearRecommendation = "Regnjacka och regnbyxor";
    } elseif ($temp >= 0) {
        $innerWearRecommendation = "Ullunderställ på under- och överkropp. Skjorta eller collegetröja.";
        $outerWearRecommendation = "Fodrat regnställ";
    } elseif ($temp >= -5) {
        $innerWearRecommendation = "Ullunderställ på under- och överkropp. Mellanlager, skjorta eller t-shirt. Därefter en varm tröja.";
        $outerWearRecommendation = "Fodrad jacka och täckbyxor. Gärna fodrat regnställ om risk för slaskväder";
    } else {
        $innerWearRecommendation = "Ullunderställ på under- och överkropp. Mellanlager, skjorta eller t-shirt. Därefter en ulltröja.";
        $outerWearRecommendation = "Fodrad jacka och täckbyxor";
    }
}


//Mössa och vantar
$headwearRecommendation = "";
$mittensRecommendation = "";

if ($temp < 10) {
    if ($precip >= 2) {
        if ($temp >= 5) {
            $mittensRecommendation = "Galonvantar.";
            $headwearRecommendation = "Sydväst.";
        } elseif ($temp >= 0) {
            $mittensRecommendation = "Fodrade galonvantar.";
            $headwearRecommendation = "Fleecefodrad sydväst.";
        } else {
            $mittensRecommendation = "Varma vintervantar, gärna ullfodrade.";
            $headwearRecommendation = "Varm mössa, gärna i ull.";
        }
    } elseif ($precip >= 1) {
        if ($temp >= 5) {
            $mittensRecommendation = "Vantar som tål lite väta.";
            $headwearRecommendation = "Sydväst eller vanlig mössa.";
        } elseif ($temp >= 0) {
            $mittensRecommendation = "Varma vantar som tål lite väta.";
            $headwearRecommendation = "Varm mössa.";
        } else {
            $mittensRecommendation = "Varma vintervantar, gärna ullfodrade.";
            $headwearRecommendation = "Varm mössa, gärna i ull.";
        }
    } else { // dry
        if ($temp >= 5) {
            $mittensRecommendation = "Fingervantar eller tunna vantar.";
            $headwearRecommendation = "Mössa.";
        } elseif ($temp >= 0) {
            $mittensRecommendation = "Fodrade vantar.";
            $headwearRecommendation = "Varm mössa.";
        } elseif ($temp >= -5) {
            $mittensRecommendation = "Varma vintervantar, gärna ullfodrade.";
            $headwearRecommendation = "Varm mössa, gärna i ull eller liknande.";
        } else {
            $mittensRecommendation = "Innervantar i ull + varma vintervantar ovanpå.";
            $headwearRecommendation = "Balaklava + varm mössa i ull.";
        }
    }
}

    // 5️⃣ Bygg HTML-output med ikoner
    $output  = "<div class='kids-clothes-box'>";
    $output .= "<p><strong>Klädrekommendationer för {$day} (baserat på kategori):</strong></p>";
    $output .= "Min temp: {$temp}°C<br>";
    $output .= "Nederbörd: {$precip} mm<br>";
    $output .= "Vind: {$wind_m_s} m/s</p>";

    $output .= "<ul>";
    $output .= "<li>👟 <strong>På fötterna:</strong> " . esc_html($shoesRecommendation) . "</li>";
    $output .= "<li>👕👖 <strong>Innerkläder:</strong> " . esc_html($innerWearRecommendation) . "</li>";
    if (!empty($outerWearRecommendation)) {
        $output .= "<li>🧥 <strong>Ytterkläder:</strong> " . esc_html($outerWearRecommendation) . "</li>";
    }
    if (!empty($mittensRecommendation)) {
        $output .= "<li>🧤 <strong>På händerna:</strong> " . esc_html($mittensRecommendation) . "</li>";
    }
    if (!empty($headwearRecommendation)) {
    $output .= "<li>🧢 <strong>På huvudet:</strong> " . esc_html($headwearRecommendation) . "</li>";
    }
    $output .= "</ul>";
    $output .= "</div>";

    return $output;
});


