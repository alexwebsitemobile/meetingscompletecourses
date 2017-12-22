<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
    <head>
        <meta charset="<?php bloginfo('charset') ?>" />
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description" content="<?php bloginfo('description') ?>" />
        <link rel="apple-touch-icon" sizes="57x57" href="<?php bloginfo('template_url') ?>/images/icons/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="<?php bloginfo('template_url') ?>/images/icons/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php bloginfo('template_url') ?>/images/icons/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?php bloginfo('template_url') ?>/images/icons/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php bloginfo('template_url') ?>/images/icons/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?php bloginfo('template_url') ?>/images/icons/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="<?php bloginfo('template_url') ?>/images/icons/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?php bloginfo('template_url') ?>/images/icons/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="<?php bloginfo('template_url') ?>/images/icons/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="<?php bloginfo('template_url') ?>/images/icons/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php bloginfo('template_url') ?>/images/icons/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="<?php bloginfo('template_url') ?>/images/icons/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php bloginfo('template_url') ?>/images/icons/favicon-16x16.png">
        <link rel="manifest" href="<?php bloginfo('template_url') ?>/images/icons/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="<?php bloginfo('template_url') ?>/images/icons/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

        <?php wp_head() ?>

        <script src="<?php bloginfo('template_url') ?>/js/jquery.parallax-1.1.3.js" type="text/javascript"></script>


    </head>

    <body <?php body_class('bg-blue') ?> itemscope itemtype="http://schema.org/WebPage">

        <?php
        do_action('before_main_content');
        get_template_part('components/bs-main-navbar');
        ?>