<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="follow, index">
    <title> <?php echo $this->config->item('site_name'); ?></title>
    <meta name="description" content="<?php echo $this->config->item('meta_description'); ?>">
    <meta name="author" content="<?php echo $this->config->item('meta_google_plus'); ?>">
    <meta name="keywords" content="<?php echo $this->config->item('meta_keywords'); ?>">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@<?php echo $this->config->item('Twitter_handle'); ?>">
    <meta name="twitter:creator" content="">
    <meta name="twitter:title" content="">
    <meta name="twitter:description" content="<?php echo $this->config->item('meta_description'); ?>">
    <meta name="twitter:image" content="">
    <!-- Facebook Open Graph -->
    <meta property="og:title" content=""/>
    <meta property="og:type" content=""/>
    <meta property="og:description" content=""/>
    <meta property="og:image" content=""/>
    <meta property="og:url" content=""/>
    <meta property="og:site_name" content="<?php echo $this->config->item('site_name'); ?>"/>
    <!-- Google Plus -->
    <meta itemprop="name" content=""/>
    <meta itemprop="image" content=""/>
    <meta itemprop="description" content="<?php echo $this->config->item('meta_description'); ?>"/>

    <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap/jquery.dataTables.css"/>

    <?php
    Assets::clear_cache();
    Assets::css($this->config->item('theme_css')); ?>
    <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap/styles.css"/>

    <link rel="stylesheet" type="text/css" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css"/>
    <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script src="/assets/js/jquery.dataTables.min.js"></script>
    <script src="/assets/js/backstretch.js"></script>
    <script src="/assets/js/patient_functions.js"></script>
    <script src="/assets/js/order_functions.js"></script>
    <script src="/assets/js/formula_functions.js"></script>
    <script src="/assets/js/page_functions.js"></script>
    <?php Assets::js($this->config->item('theme_js')); ?>
    
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">    
    <link rel="shortcut icon" href="/favicon.ico">
    
		<link href='//fonts.googleapis.com/css?family=Josefin+Sans:400,600,700|Montserrat:400,700' rel='stylesheet' type='text/css'>
		<link href='//fonts.googleapis.com/css?family=Roboto+Slab:400,700,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" type='text/css'>
</head>