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
add_shortcode('test_weather', function() {

    // Example location — replace with your preschool's coords
    $lat = 59.354625932401774;
    $lon = 18.167468192093725;

    // Simple Open-Meteo forecast API call
    $url = add_query_arg(array(
        'latitude' => $lat,
        'longitude' => $lon,
        'current_weather' => 'true'
    ), 'https://api.open-meteo.com/v1/forecast');

    $response = wp_remote_get($url, array('timeout'=>10));

    if (is_wp_error($response)) {
        return '<p>Weather error: could not connect.</p>';
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (empty($data) || !isset($data['current_weather']['temperature'])) {
        return '<p>Weather error: data missing.</p>';
    }

    $temp = $data['current_weather']['temperature'];
    

    // SUPER basic output
    return "<p>Current temperature: <strong>{$temp}°C</strong></p>";
});

add_shortcode('kids_clothes', function() {

    /* ----------------------------------------------------------
       1. Bestäm om vi visar IDAG eller IMORGON
    ---------------------------------------------------------- */

    $current_hour = (int) current_time('H');

    if ($current_hour >= 17) {
        $day = 'imorgon';
        $index = 1;
    } else {
        $day = 'idag';
        $index = 1;
    }

    /* ----------------------------------------------------------
       2. Hämta Open-Meteo daglig prognos
    ---------------------------------------------------------- */

    $lat = 59.354625932401774;
    $lon = 18.167468192093725;

    $url = add_query_arg(array(
        'latitude' => $lat,
        'longitude' => $lon,
        'daily' => 'temperature_2m_max,temperature_2m_min,precipitation_sum,windspeed_10m_max',
        'timezone' => 'auto'
    ), 'https://api.open-meteo.com/v1/forecast');

    $response = wp_remote_get($url, array('timeout' => 10));

    if (is_wp_error($response)) {
        return "<p>Väderfel: kunde inte ansluta.</p>";
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (empty($data['daily'])) {
        return "<p>Väderfel: prognos saknas.</p>";
    }

    /* ----------------------------------------------------------
       3. Extrahera dagliga värden
    ---------------------------------------------------------- */

    $max_temp = $data['daily']['temperature_2m_max'][$index];
    $min_temp = $data['daily']['temperature_2m_min'][$index];
    $precip   = $data['daily']['precipitation_sum'][$index];
    $wind_kmh = $data['daily']['windspeed_10m_max'][$index];

    // Konvertera km/h → m/s
    $wind_m_s = round($wind_kmh / 3.6, 1);

    // Enkelt "känns som"-justering
    $feels_like = $min_temp - ($wind_m_s * 1); // vindkyla

    /* ----------------------------------------------------------
       4. Klädrekommendationer (med realistiska vindtrösklar)
    ---------------------------------------------------------- */

    $recommendations = array();

    // Temperaturlager
    if ($max_temp >= 18) {
        $recommendations[] = "Lätta kläder (t-shirt, tunna byxor)";
    } elseif ($max_temp >= 12) {
        $recommendations[] = "Mellanskikt (långärmat, lätt jacka)";
    } elseif ($max_temp >= 5) {
        $recommendations[] = "Varma lager (fleece, varm jacka)";
    } else {
        $recommendations[] = "Vinterkläder (termolager, varm jacka)";
    }

    // Morgonkyl
    if ($min_temp < 5) {
        $recommendations[] = "Mössa och vantar på morgonen";
    }

    // Känns kallt pga vind
    if ($feels_like < 0) {
        $recommendations[] = "Vindskyddande ytterlager";
    }

    // Regn
    if ($precip >= 5) {
        $recommendations[] = "Fullt regnställ (regnjacka, byxor, stövlar)";
    } elseif ($precip > 0) {
        $recommendations[] = "Lätt regnskydd (skaljacka)";
    }

    // Vind — trösklar nu i m/s
    if ($wind_m_s >= 10) { // mycket stark vind
        $recommendations[] = "Vindjacka och mössa";
    } elseif ($wind_m_s >= 5) { // måttlig vind
        $recommendations[] = "Vindjacka";
    }

    /* ----------------------------------------------------------
       5. Bygg HTML-utdata
    ---------------------------------------------------------- */

    $output  = "<div class='kids-clothes-box'>";
    $output .= "<p><strong>Klädrekommendation för {$day}:</strong></p>";
    $output .= "<p>Max temp: {$max_temp}°C<br>";
    $output .= "Min temp: {$min_temp}°C<br>";
    $output .= "Nederbörd: {$precip} mm<br>";
    $output .= "Vind: {$wind_m_s} m/s</p>";

    $output .= "<ul>";
    foreach ($recommendations as $item) {
        $output .= "<li>" . esc_html($item) . "</li>";
    }
    $output .= "</ul>";
    $output .= "</div>";

    return $output;
});

add_shortcode('kids_clothes_ai', function() {

    // 1️⃣ Dagsval (idag/imorgon)
    $current_hour = (int) current_time('H');
    if ($current_hour >= 17) {
        $day = 'imorgon';
        $index = 1;
    } else {
        $day = 'idag';
        $index = 0;
    }

    // 2️⃣ Open-Meteo-data
    $lat = 59.354625932401774;
    $lon = 18.167468192093725;

    $url = add_query_arg(array(
        'latitude' => $lat,
        'longitude' => $lon,
        'daily' => 'temperature_2m_max,temperature_2m_min,precipitation_sum,windspeed_10m_max',
        'timezone' => 'auto'
    ), 'https://api.open-meteo.com/v1/forecast');

    $response = wp_remote_get($url, array('timeout' => 10));
    if (is_wp_error($response)) {
        return "<p>Väderfel: kunde inte ansluta.</p>";
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    if (empty($data['daily'])) {
        return "<p>Väderfel: prognos saknas.</p>";
    }

    // 3️⃣ Hämta värden
    $max_temp = $data['daily']['temperature_2m_max'][$index];
    $min_temp = $data['daily']['temperature_2m_min'][$index];
    $precip   = $data['daily']['precipitation_sum'][$index];
    $wind_kmh = $data['daily']['windspeed_10m_max'][$index];

    $wind_m_s = round($wind_kmh / 3.6, 1);
    $feels_like = $min_temp - ($wind_m_s * 1);

    // 4️⃣ AI-liknande naturligt språk baserat på värden
    $recommendations = array();

    // Temperatur
    if ($max_temp >= 18) {
        $recommendations[] = "En lätt t-shirt och tunna byxor räcker, men ha gärna en tunn tröja till hands.";
    } elseif ($max_temp >= 12) {
        $recommendations[] = "En långärmad tröja med en lätt jacka passar bra, så barnet håller sig varmt när det leker.";
    } elseif ($max_temp >= 5) {
        $recommendations[] = "Ta på barnet varma lager, till exempel fleece och en varm jacka, för att hålla mysigt under uteleken.";
    } else {
        $recommendations[] = "Det är kallt! Vinterkläder med termolager och varm jacka behövs.";
    }

    // Morgonkyl
    if ($min_temp < 5) {
        $recommendations[] = "Glöm inte mössa och vantar på morgonen så barnet håller sig varmt.";
    }

    // Vindkänsla
    if ($feels_like < 0) {
        $recommendations[] = "En vindjacka eller vindskyddande lager hjälper barnet att hålla värmen under blåsiga perioder.";
    }

    // Regn
    if ($precip >= 5) {
        $recommendations[] = "Det kommer regn — regnställ med byxor och stövlar är perfekt.";
    } elseif ($precip > 0) {
        $recommendations[] = "Ta med en skaljacka som skyddar mot lätt regn.";
    }

    // Vindstyrka
    if ($wind_m_s >= 10) {
        $recommendations[] = "Starka vindar idag! Vindjacka och mössa rekommenderas.";
    } elseif ($wind_m_s >= 5) {
        $recommendations[] = "Måttlig vind, en vindjacka kan vara bra.";
    }

    // 5️⃣ Bygg HTML-output
    $output  = "<div class='kids-clothes-box'>";
    $output .= "<p><strong>AI-inspirerad klädrekommendation för {$day}:</strong></p>";
    $output .= "<p>Max temp: {$max_temp}°C<br>";
    $output .= "Min temp: {$min_temp}°C<br>";
    $output .= "Nederbörd: {$precip} mm<br>";
    $output .= "Vind: {$wind_m_s} m/s</p>";

    $output .= "<ul>";
    foreach ($recommendations as $item) {
        $output .= "<li>" . esc_html($item) . "</li>";
    }
    $output .= "</ul>";
    $output .= "</div>";

    return $output;

});


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
    $min_temp = $data['daily']['temperature_2m_min'][$index];
    $precip   = $data['daily']['precipitation_sum'][$index];
    $wind_kmh = $data['daily']['windspeed_10m_max'][$index];
    $wind_m_s = round($wind_kmh / 3.6, 1);
    $feels_like = $min_temp - ($wind_m_s * 1);

    // 4️⃣ Klädkategorier med logik

    // Fötter 👢
    if ($max_temp < 5) {
        $feet = $precip > 0 ? "Galonstövlar med fleece sockor" : "Vinterstövlar";
    } elseif ($precip > 0) {
        $feet = "Vattentåliga skor / Galonstövlar";
    } else {
        $feet = "Vanliga skor / sneakers";
    }

    // Kropp 🧥
    $body = "";
    if ($max_temp < 5) {
        $body .= "Termolager + varm jacka";
    } elseif ($max_temp < 12) {
        $body .= "Fleece / mellanskikt";
    } else {
        $body .= "Lätt tröja / t-shirt";
    }
    if ($precip > 0) $body .= " + Vattentät jacka";
    if ($wind_m_s >= 5) $body .= " + Vindjacka";

    // Händer 🧤
    $hands = "";
    if ($min_temp < 5) $hands .= "Mössa + vantar";
    if ($wind_m_s >= 5 && $min_temp < 10) $hands .= " / Vindvantar";

    // Huvud 🎩
    $head = "";
    if ($min_temp < 5) {
        $head .= "Mössa";
    } elseif ($wind_m_s >= 5) {
        $head .= "Lätt huvudskydd / huva";
    }

    // 5️⃣ Bygg HTML-output med ikoner
    $output  = "<div class='kids-clothes-box'>";
    $output .= "<p><strong>Klädrekommendationer för {$day} (baserat på kategori):</strong></p>";
    $output .= "<p>Max temp: {$max_temp}°C<br>";
    $output .= "Min temp: {$min_temp}°C<br>";
    $output .= "Nederbörd: {$precip} mm<br>";
    $output .= "Vind: {$wind_m_s} m/s</p>";

    $output .= "<ul>";
    $output .= "<li>👢 <strong>Fötter:</strong> " . esc_html($feet) . "</li>";
    $output .= "<li>🧥 <strong>Kropp:</strong> " . esc_html($body) . "</li>";
    $output .= "<li>🧤 <strong>Händer:</strong> " . esc_html($hands) . "</li>";
    $output .= "<li>🎩 <strong>Huvud:</strong> " . esc_html($head) . "</li>";
    $output .= "</ul>";
    $output .= "</div>";

    return $output;
});


