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
    // Always enqueue main site JS & CSS
    wp_enqueue_style( 'mulleborg-style', get_stylesheet_uri() );
    wp_enqueue_script( 'mulleborg-script', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), null, true );

    // Only pass AJAX URL if the kids-weather button is enabled
    if ( get_option('mulleborg_kids_weather_enabled', 1) ) {
        wp_localize_script( 'mulleborg-script', 'mulleborg_ajax', array(
            'ajax_url' => admin_url( 'admin-ajax.php' )
        ));
    }
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
// THIS IS WHERE THE WEATHER MAGIC HAPPENS
// --------------------
add_shortcode('kids_clothes_temp_for_windchill', function() {

   //  Bestäm idag/imorgon
$current_hour = (int) current_time('H');
if ($current_hour >= 17) {
    $day = 'imorgon';
    $index = 1;
} else {
    $day = 'idag';
    $index = 0;
}

//  Hämta Open-Meteo prognos (TIMVIS)
$lat = 59.354625932401774;
$lon = 18.167468192093725;

$url = add_query_arg(array(
    'latitude' => $lat,
    'longitude' => $lon,
    'hourly' => 'temperature_2m,precipitation,weathercode,windspeed_10m,is_day',
    'timezone' => 'Europe/Stockholm'
), 'https://api.open-meteo.com/v1/forecast');

$response = wp_remote_get($url, array('timeout' => 10));
if (is_wp_error($response)) return "<!--weather-error--><p>Väderfel: kunde inte ansluta.</p>";


$body = wp_remote_retrieve_body($response);
$data = json_decode($body, true);
if (empty($data['hourly'])) return "<!--weather-error--><p>Väderfel: prognos saknas.</p>";


// Skapa en array med timvis data
$times  = $data['hourly']['time'];
$temps  = $data['hourly']['temperature_2m'];
$prec   = $data['hourly']['precipitation'];
$wcodes = $data['hourly']['weathercode'];
$winds  = $data['hourly']['windspeed_10m'];

$is_day_arr = $data['hourly']['is_day'];

// Identifiera vilka timmar som hör till idag eller imorgon
// $target_date = date('Y-m-d', strtotime("+$index day"));
$target_date = wp_date('Y-m-d', strtotime("+$index day"), wp_timezone());


// Filtrera fram enbart timmar mellan 07–17
$daytime_data = array();
for ($i = 0; $i < count($times); $i++) {
    $t = strtotime($times[$i]);

    if (date('Y-m-d', $t) !== $target_date) continue;

    $hour = (int) date('H', $t);
if ($hour >= 7 && $hour <= 17) {
    $daytime_data[] = array(
        'temp'     => $temps[$i],
        'prec'     => $prec[$i],
        'wcode'    => $wcodes[$i],
        'wind_ms'  => $winds[$i] / 3.6,
        'wind_kmh' => $winds[$i],
        'is_day'   => (int) $is_day_arr[$i],
    );
}

}

//  Sammanställ prognos för dagtid
if (empty($daytime_data)) {
    return "<!--weather-error--><p>Väderprognos för dagtid saknas just nu. Försök igen lite senare.</p>";
}

$is_dark = true;
foreach ($daytime_data as $hour) {
    if ($hour['is_day'] === 1) {
        $is_dark = false;
        break;
    }
}

$temp = array_sum(array_column($daytime_data, 'temp')) / count($daytime_data);
$wind_values_kmh = array_column($daytime_data, 'wind_kmh');
$wind_values_ms  = array_column($daytime_data, 'wind_ms');
$max_wind_kmh = !empty($wind_values_kmh) ? max($wind_values_kmh) : 0;
$max_wind_ms  = !empty($wind_values_ms) ? max($wind_values_ms) : 0;
$wind_m_s     = $max_wind_ms;
$precip = $precip = array_sum(array_column($daytime_data, 'prec'));
$weather_codes = array_column($daytime_data, 'wcode');
$clear_sky = in_array(0, $weather_codes) || in_array(1, $weather_codes);


// Use proper wind chill formula only when applicable
if ($temp <= 10 && $max_wind_kmh >= 5) {
    // Real official wind chill
    $feels_like = 13.12 
                + (0.6215 * $temp) 
                - (11.37 * pow($max_wind_kmh, 0.16)) 
                + (0.3965 * $temp * pow($max_wind_kmh, 0.16));
} else {
    // Otherwise feels-like = temperature (no meaningful wind chill)
    $feels_like = $temp;
}

$hasSun   = false;
$hasCloud = false;
$hasRain  = false;
$hasSnow  = false;
$hasFog   = false;
$hasStorm = false;

foreach ($weather_codes as $code) {
    if ($code === 0) $hasSun = true;
    if (in_array($code, [1,2,3])) $hasCloud = true;
    if (in_array($code, [51,53,55,61,63,65,80,81,82])) $hasRain = true;
    if (in_array($code, [71,73,75,77,85,86])) $hasSnow = true;
    if (in_array($code, [45,48])) $hasFog = true;
    if (in_array($code, [95,96,99])) $hasStorm = true;
}

$icons = '';

// Worst weather first
if ($hasStorm) {
    $icons .= '⛈️';
} elseif ($hasSnow) {
    $icons .= '❄️';
} elseif ($hasRain) {
    $icons .= '🌧️';
} elseif ($hasFog) {
    $icons .= '🌫️';
} else {
   // No precipitation or storm → sky state
    if ($is_dark) {
        $icons .= '🌙';
    } elseif ($hasSun && $hasCloud) {
        $icons .= '🌤️'; 
    } elseif ($hasSun) {
        $icons .= '☀️'; 
    } elseif ($hasCloud) {
        $icons .= '☁️';
    }
}

if ($max_wind_ms >= 6) {
    $icons .= ' 🌬️';
}

// CLOTHING RECOMMENDATIONS

//SKOR 

$shoesRecommendation = "";

// Rain / wet conditions (rubber boots logic)
if ($precip > 1 && $temp >= 0) {

    if ($temp >= 7) {
        $shoesRecommendation = "Gummistövlar";
    } elseif ($temp >= 4) {
        $shoesRecommendation = "Fodrade gummistövlar/gummistövlar + ullstrumpor";
    } else { // 0–3°C
        $shoesRecommendation = "Fodrade gummistövlar + ullstrumpor";
    }

}
// Dry conditions (temperature logic)
else {

    if ($temp >= 23) {
        $shoesRecommendation = "Sandaler";
    } elseif ($temp >= 17) {
        $shoesRecommendation = "Gympaskor/Sandaler";
    } elseif ($temp >= 10) {
        $shoesRecommendation = "Gympaskor";
    } elseif ($temp >= 5) {
        $shoesRecommendation = "Kängor/Rejälare skor";
    } elseif ($temp >= 3) {
        $shoesRecommendation = "Kängor/Vinterskor.";
    } elseif ($temp >= 0) {
        $shoesRecommendation = "Kängor/Vinterskor + ev. ullstrumpor";
    } elseif ($temp >= -5) {
        $shoesRecommendation = "Fodrade vinterskor + ullstrumpor";
    } else { // Below -5
        $shoesRecommendation = "Fodrade vinterskor + dubbla ullstrumpor";
    }

}


// KROPPEN
$innerWearRecommendation = "";
$outerWearRecommendation = "";

if ($precip <= 1) { // Dry conditions
    if ($temp >= 23) {
        $innerWearRecommendation = "Shorts och linne/t-shirt";
        $outerWearRecommendation = "";
    } elseif ($temp >= 20) {
        $innerWearRecommendation = "Shorts/Långbyxor och t-shirt/linne";
        $outerWearRecommendation = "";
    } elseif ($temp >= 17) {
        $innerWearRecommendation = "Långbyxor och kort- eller långärmad tröja";
        $outerWearRecommendation = "";
    } elseif ($temp >= 14) {
        $innerWearRecommendation = "Långbyxor, t-shirt och tjocktröja";
        $outerWearRecommendation = "";
    } elseif ($temp >= 10) {
        $innerWearRecommendation = "Långbyxor, t-shirt och tjocktröja";
        $outerWearRecommendation = "Tunn jacka";
    } elseif ($temp >= 5) {
        $innerWearRecommendation = "Långbyxor eller underställsbyxor, lager på lager på överkroppen";
        $outerWearRecommendation = "Skaljacka och skalbyxor";
    } elseif ($temp >= 0) {
        $innerWearRecommendation = "Helt ullunderställ och tjocktröja";
        $outerWearRecommendation = "Fodrad jacka och fodrade byxor eller skalbyxor";
    } elseif ($temp >= -5) {
        $innerWearRecommendation = "Helt ullunderställ, mellanlager, varm tröja";
        $outerWearRecommendation = "Fodrad jacka och fodrade byxor";
    } else {
        $innerWearRecommendation = "Helt ullunderställ, mellanlager, tjock ulltröja";
        $outerWearRecommendation = "Fodrad jacka och fodrade byxor";
    }
} 
else { // Wet conditions
    if ($temp >= 23) {
        $innerWearRecommendation = "Shorts och linne/t-shirt";
        $outerWearRecommendation = "Tunn regnjacka";
    } elseif ($temp >= 20) {
        $innerWearRecommendation = "Shorts/Långbyxor och t-shirt/linne";
        $outerWearRecommendation = "Regnjacka och regnbyxor";
    } elseif ($temp >= 17) {
        $innerWearRecommendation = "Långbyxor och kort- eller långärmad tröja.";
        $outerWearRecommendation = "Regnjacka och regnbyxor";
    } elseif ($temp >= 14) {
        $innerWearRecommendation = "Långbyxor, t-shirt och tjocktröja";
        $outerWearRecommendation = "Regnjacka och regnbyxor";
    } elseif ($temp >= 10) {
        $innerWearRecommendation = "Långbyxor, t-shirt och tjocktröja";
        $outerWearRecommendation = "Regnjacka och regnbyxor";
    } elseif ($temp >= 5) {
        $innerWearRecommendation = "Långbyxor eller underställsbyxor, lager på lager på överkroppen";
        $outerWearRecommendation = "Regnjacka och regnbyxor";
    } elseif ($temp >= 0) {
        $innerWearRecommendation = "Helt ullunderställ och tjocktröja";
        $outerWearRecommendation = "Fodrat regnställ";
    } elseif ($temp >= -5) {
        $innerWearRecommendation = "Helt ullunderställ, mellanlager, varm tröja";
        $outerWearRecommendation = "Fodrad jacka och täckbyxor. Gärna fodrat regnställ om risk för slaskväder";
    } else {
        $innerWearRecommendation = "Helt ullunderställ, mellanlager, tjock ulltröja";
        $outerWearRecommendation = "Fodrad jacka och täckbyxor";
    }
}


//Mössa och vantar
$headwearRecommendation = "";
$mittensRecommendation = "";

if ($temp < 10) {
    if ($precip >= 2) {
        if ($temp >= 5) {
            $mittensRecommendation = "Galonvantar";
            $headwearRecommendation = "Sydväst";
        } elseif ($temp >= 0) {
            $mittensRecommendation = "Fodrade galonvantar";
            $headwearRecommendation = "Fleecefodrad sydväst";
        } else {
            $mittensRecommendation = "Varma vintervantar, gärna ullfodrade";
            $headwearRecommendation = "Varm mössa, gärna i ull";
        }
    } elseif ($precip >= 1) {
        if ($temp >= 5) {
            $mittensRecommendation = "Vanttenavstötande vantar";
            $headwearRecommendation = "Sydväst/Vanlig mössa";
        } elseif ($temp >= 0) {
            $mittensRecommendation = "Varma, vattenavstötande vantar";
            $headwearRecommendation = "Varm mössa";
        } else {
            $mittensRecommendation = "Varma vintervantar, gärna ullfodrade";
            $headwearRecommendation = "Varm mössa, gärna i ull";
        }
    } else { // dry
        if ($temp >= 5) {
            $mittensRecommendation = "Fingervantar/lite tunnare vantar";
            $headwearRecommendation = "Mössa";
        } elseif ($temp >= 0) {
            $mittensRecommendation = "Fodrade vantar";
            $headwearRecommendation = "Varm mössa";
        } elseif ($temp >= -5) {
            $mittensRecommendation = "Varma vintervantar, gärna ullfodrade";
            $headwearRecommendation = "Varm mössa, gärna i ull";
        } else {
            $mittensRecommendation = "Innervantar i ull + varma vintervantar ovanpå";
            $headwearRecommendation = "Balaklava + varm mössa i ull";
        }
    }
} elseif ($clear_sky && $temp >= 18) {
    $headwearRecommendation = "En keps på huvudet och/eller solkräm";
}

    // HTML-output med ikoner
    $output  = "<div class='kids-clothes-box flex'>";
    $output .= "<h2><strong>Vad ska mitt barn ha på sig på Mulleborg {$day}?</strong></h2>";
    $output .= "<ul style='text-align: left'>";
        if (!empty($headwearRecommendation)) {
    $output .= "<li>🧢 " . esc_html($headwearRecommendation) . "</li>";
    }
   
    $output .= "<li>👕 " . esc_html($innerWearRecommendation) . "</li>";
    if (!empty($outerWearRecommendation)) {
        $output .= "<li>🧥 " . esc_html($outerWearRecommendation) . "</li>";
    }
    if (!empty($mittensRecommendation)) {
        $output .= "<li>🧤 " . esc_html($mittensRecommendation) . "</li>";
    }
     $output .= "<li>👟 " . esc_html($shoesRecommendation) . "</li>";

    $output .= "</ul>";
    $output .= "<div class='weather-conditions-box'>";
    $output .= "<div class='weather-illustration'>{$icons}</div>";
    $output .= "<h3> " . round($temp, 1) . "°C</h3>";
    $output .= "Känns som: " . round($feels_like, 1) . "°C<br>";
    $output .= "Nederbörd: {$precip} mm<br>";
    $output .= "Vind: " . round($wind_m_s, 1) . " m/s";
    $output .= "</div>";
   // Weather illustration / visual

$output .= "</div>"; // close main box

    return $output;
});

function mulleborg_ajax_kids_clothes() {
    nocache_headers();

    $use_cache = true;
    $cache_key = 'kids_clothes_forecast_v1';

    // get cached value to use as fallback
    $cached = $use_cache ? get_transient( $cache_key ) : false;

    ob_start();
    echo do_shortcode('[kids_clothes_temp_for_windchill]');
    $output = ob_get_clean();

    $is_error = str_contains( $output, '<!--weather-error-->' );

    if ( ! $is_error ) {
        // When fresh output is valid → cache & serve
        if ( $use_cache ) {
            set_transient( $cache_key, $output, 900 );
        }
        echo $output;
    } elseif ( $cached !== false ) {
        // ⚠️ Fresh output failed → serve last good cache
        echo $cached;
    } else {
        // No cache exists → serve "real"/fresh data
        echo $output;
    }

    wp_die();
}


add_action( 'wp_ajax_get_kids_clothes', 'mulleborg_ajax_kids_clothes' );
add_action( 'wp_ajax_nopriv_get_kids_clothes', 'mulleborg_ajax_kids_clothes' );

// Customizer section to toggle the kids weather button on and off
function mulleborg_customize_register( $wp_customize ) {

    $wp_customize->add_section( 'kids_weather_section', array(
        'title'    => __('Kids Weather Button', 'mulleborg'),
        'priority' => 160,
    ));

    $wp_customize->add_setting( 'kids_weather_enabled', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control( 'kids_weather_enabled', array(
        'label'    => __('Show Kids Weather Button?', 'mulleborg'),
        'section'  => 'kids_weather_section',
        'type'     => 'checkbox',
    ));

}
add_action( 'customize_register', 'mulleborg_customize_register' );

// Helper that returns 'idag' or 'imorgon' based on current time
function mulleborg_get_day_label() {
    $current_hour = (int) current_time('H'); 
    if ($current_hour >= 17) {
        return 'imorgon';
    } else {
        return 'idag';
    }
}

