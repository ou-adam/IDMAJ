<?php
// includes/lang.php: Multilingual Language Handler (AR, FR, EN)

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Available languages
$allowed_langs = ['ar', 'fr', 'en'];
$default_lang = 'ar';

// Check for language change request via GET
if (isset($_GET['lang']) && in_array($_GET['lang'], $allowed_langs)) {
    $current_lang = $_GET['lang'];
    $_SESSION['lang'] = $current_lang;
    setcookie('idmaj_lang', $current_lang, time() + (86400 * 30), "/"); // 30 days
} elseif (isset($_SESSION['lang']) && in_array($_SESSION['lang'], $allowed_langs)) {
    $current_lang = $_SESSION['lang'];
} elseif (isset($_COOKIE['idmaj_lang']) && in_array($_COOKIE['idmaj_lang'], $allowed_langs)) {
    $current_lang = $_COOKIE['idmaj_lang'];
    $_SESSION['lang'] = $current_lang;
} else {
    $current_lang = $default_lang;
    $_SESSION['lang'] = $current_lang;
}

$lang = $current_lang;
$dir = ($lang === 'ar') ? 'rtl' : 'ltr';

// Load language dictionary
$lang_file = __DIR__ . '/../languages/' . $lang . '.php';
if (file_exists($lang_file)) {
    $t = require $lang_file;
} else {
    $fallback_file = __DIR__ . '/../languages/ar.php';
    $t = file_exists($fallback_file) ? require $fallback_file : [];
}

/**
 * Translation helper function
 *
 * @param string $key Dictionary key
 * @param string $default Fallback string if key is missing
 * @return string Translated string
 */
function t($key, $default = '') {
    global $t;
    if (isset($t[$key]) && $t[$key] !== '') {
        return $t[$key];
    }
    return ($default !== '') ? $default : $key;
}

/**
 * Generate URL with updated language parameter
 *
 * @param string $target_lang Target language code ('ar', 'fr', 'en')
 * @return string
 */
function get_lang_url($target_lang) {
    $params = $_GET;
    $params['lang'] = $target_lang;
    return '?' . http_build_query($params);
}

