<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<link rel="shortcut icon" href="/assets/imgs/favicon.ico">
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,200i,300,300i,400,400i,600,600i,700,700i,900,900i&amp;subset=cyrillic,cyrillic-ext" rel="stylesheet">
<link rel="stylesheet" href="/assets/css/vendor.css">
<link rel="stylesheet" href="/assets/css/app.css">

<?php print_js_var('timezone', get_usersettings('timezone', 'Europe/London')); ?>
<?php print_js_var('lang', get_usersettings('lang', 'en')); ?>
