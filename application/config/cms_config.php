<?php

// Site Name - Used for Templates
$config['site_name'] = 'Golden Cabinet Herbs';
$config['meta_author'] = 'Golden Cabinet';
$config['meta_description'] = 'Golden Cabinet';
$config['meta_google_plus'] = 'Golden Cabinet';
$config['meta_keywords'] = 'Golden Cabinet, Herbs';
$config['Twitter_handle'] = 'goldencabinetherbs';


// Set root directory 
$config['root_path'] = $_SERVER['DOCUMENT_ROOT'];

//Set Javascript files to load from CDN
$config['theme_jscdn'] = array('jquery');

$config['theme_js'] = array('bootstrap.min.js', 'jquery.tablesorter.js');
$config['theme_css'] = array('bootstrap.min.css','bootstrap/styles.css','bootstrap/bootstrap-overrides.css');

/** SET THEME VARIABLES **/

$config['theme'] = 'default';
$config['theme_full_width'] = 'themes/' . $config['theme'] . '/pagetypes/full-width';
$config['standard-page'] = 'themes/' . $config['theme'] . '/pagetypes/standard-page';
$config['formula'] = 'themes/' . $config['theme'] . '/pagetypes/formula';
$config['theme_home'] = 'themes/' . $config['theme'] . '/pagetypes/home';
$config['plain-text'] = 'themes/' . $config['theme'] . '/pagetypes/plain-text';


/** PARTIALS **/

$config['theme_header'] = 'themes/' . $config['theme'] . '/partials/head';
$config['theme_footer'] = 'themes/' . $config['theme'] . '/partials/footer';
$config['meta_analytics'] = 'themes/' . $config['theme'] . '/partials/analytics';
$config['theme_header_navigation'] = 'themes/' . $config['theme'] . '/partials/header-navigation';


$config['theme_right_side_bar'] = 'theme/' . $config['theme'] . '/partials/right-sidebar';
$config['theme_top_nav'] = 'theme/' . $config['theme'] . '/partials/nav';
$config['theme_main_ad'] = 'theme/' . $config['theme'] . '/partials/main-ad';
$config['theme_sidebar_ad'] = 'theme/' . $config['theme'] . '/partials/sidebar-ad';
$config['theme_disqus'] = 'theme/' . $config['theme'] . '/partials/disqus';
$config['theme_disqus_count'] = 'theme/' . $config['theme'] . '/partials/disqus-count';
$config['theme_slider'] = 'theme/' . $config['theme'] . '/partials/slider';


