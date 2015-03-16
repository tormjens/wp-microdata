<?php 

// This file is based on wp-includes/js/tinymce/langs/wp-langs.php

if ( ! defined( 'ABSPATH' ) )
    exit;

if ( ! class_exists( '_WP_Editors' ) )
    require( ABSPATH . WPINC . '/class-wp-editor.php' );

function wp_microdata_tinymce_plugin_translation() {
    $strings = array(
        'title' 			=> __('Microdata', 'wp-microdata'),
        'wrapper' 			=> __('Add Wrapper', 'wp-microdata'),
        'wrapperTitle' 		=> __('Insert Microdata Wrapper', 'wp-microdata'),
        'wrapperIntro' 		=> __('This element should wrap all elements with microdata.', 'wp-microdata'),
        'wrapperType' 		=> __('Type', 'wp-microdata'),
        'element' 			=> __('Add Element', 'wp-microdata'),
        'elementTitle' 		=> __('Insert Microdata Element', 'wp-microdata'),
        'elementIntro' 		=> __('The property of each element should match the specification for the itemscope.', 'wp-microdata'),
        'elementProperty' 	=> __('Property', 'wp-microdata'),
        'elementHTML'	 	=> __('HTML Element', 'wp-microdata')
    );
    $locale = _WP_Editors::$mce_locale;
    $translated = 'tinyMCE.addI18n("' . $locale . '.wp_microdataPlugin", ' . json_encode( $strings ) . ");\n";

    return $translated;
}

$strings = wp_microdata_tinymce_plugin_translation();
