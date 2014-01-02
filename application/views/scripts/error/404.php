<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html class="no-js" lang="en">
    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="generator" content="" />
        <?php $pageTitle = __('404 Page Not Found'); ?>
        <title><?php echo $pageTitle; ?></title>


        <link rel="stylesheet" href="<?php echo uri('plugins/ExhibitBuilder/views/public/exhibits/'); ?>css/reset.css" />
        <link rel="stylesheet" href="<?php echo uri('plugins/ExhibitBuilder/views/public/exhibits/'); ?>css/style.css" />
        <!--[if !IE 7]>
                <style type="text/css">
                        #wrap {display:table;height:100%}
                </style>
        <![endif]-->

        <link href='http://fonts.googleapis.com/css?family=Signika:400,600' rel='stylesheet' type='text/css'>

        </link>
    </head>
    <body>
        <?php
        session_start();
// store session data
//echo $locale = Zend_Registry::get('Zend_Locale');
        $_SESSION['get_language'] = get_language_for_switch();
        $_SESSION['get_language_omeka'] = get_language_for_omeka_switch();
        $_SESSION['get_language_for_internal_xml'] = get_language_for_internal_xml();
        ?>			
        <nav class="breadcrumb">
            <div class="inner">
                <span class="title" data-translation="You_are_here">You are here</span>:
                <a href="<?php echo uri('index'); ?>" data-translation="Pathways">Pathways</a>
                <span class="bc_separator">></span>
                <span class="inactive"><?php echo $pageTitle; ?></span>
            </div>
        </nav>
        <section class="inner info clearfix secwrapper" style=" position: relative; padding-top: 50px;">
            <article class="secarticle">
                <h2><?php echo $pageTitle; ?></h2>
                <p><?php echo __('Sorry for the inconvenience but this is a not valid url.'); ?>
                    <br>
                        <?php echo __(' %s', html_escape($badUri)); ?>  
                </p>
            </article>
        </section>

        <section class="inner clearfix footer">
            <a href="http://www.natural-europe.eu/"><img src="<?php echo uri(''); ?>plugins/ExhibitBuilder/views/public/exhibits/images/logo_n.png" /></a>
        </section>
    </body>
</html>
