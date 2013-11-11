<!DOCTYPE html>
<html lang="en-us">
<head>
    <meta charset="utf-8">
    <title><?php echo settings('site_title'); ?></title>
    
    <!-- Stylesheets -->
    <?php queue_css('default'); ?>
    <?php display_css(); ?>

    <!-- JavaScripts -->
    <?php display_js(); ?>

    <!-- Plugin Stuff -->
    <?php admin_plugin_header(); ?>
</head>
<body id="login" style="width:1000px;">
    <?php /*<div style="float:left;"><h1><a href="<?php echo uri('index');?>"><img src="<?php echo public_uri('themes/natural/images/interface/logonatural.png'); ?>"></a></h1></div><!--end rx div--> */?>
    <div id="wrap" style="width:1000px;">
        <div id="header" style="width:1000px;">
            <div id="site-title"><?php echo link_to_admin_home_page(); ?></div>
        </div>
        <div id="content" style="width:1000px;">
<iframe width="640" height="392" style="float:left;" src="//www.youtube.com/embed/QFXBLqZve3M" frameborder="0" allowfullscreen></iframe>