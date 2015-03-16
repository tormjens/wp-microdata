<?php  
/*
Plugin Name: WordPress Microdata
Description: Build microdata blocks using shortcodes.
Plugin URI: http://tormorten.no
Author: Tor Morten Jensen
Author URI: http://tormorten.no
Version: 1.0
License: GPL2
Text Domain: wp-microdata
Domain Path: lang/
*/

/*

    Copyright (C) 2015  Tor Morten Jensen  tormorten@tormorten.no

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


if( ! class_exists( 'WP_Microdata' ) ) {

	/**
	 * The main class for WP Microdata
	 *
	 * @package WordPress
	 **/
	class WP_Microdata {

		/**
		 * Initializes the plugin
		 *
		 * @return void
		 **/
		public function __construct() {

			self::init();

		}

		/**
		 * Get a new instance of the plugin
		 *
		 * @return object
		 **/
		public static function instance() {
			return new self;
		}

		/**
		 * Inits the actions and plugins
		 *
		 * @return void
		 * @author 
		 **/
		private static function init() {

			// wrapper shortcode
			add_shortcode( 'microdata', 			array( 'WP_Microdata', 'shortcode_microdata' ) );

			// element shortcode
			add_shortcode( 'md_item', 				array( 'WP_Microdata', 'shortcode_item' ) );

			// add the button
		 	add_action( 'init', 					array( 'WP_Microdata', 'buttonhooks' ) );

		 	// translate tinymce
		 	add_filter( 'mce_external_languages', 	array( 'WP_Microdata', 'tinymce_add_locale' ) );

		 	// translate the plugin
		 	self::load_textdomain();

		}

		/**
		 * The wrapper shortcode
		 *
		 * @param 	array 	$atts 		Shortcode attributes
		 * @param 	string 	$content 	Content inside shortcode
		 * @return 	string
		 **/
		public static function shortcode_microdata( $atts, $content = null ) {

			$atts = shortcode_atts( array(
				'type' 		=> 	'http://schema.org/Article'
			), $atts );

			$output 	 = '<div class="wp-microdata-wrapper" itemscope itemtype="'. $atts['type'] .'">' . "\n";
			
			$output 	.= do_shortcode( $content ) . "\n";

			$output 	.= '</div>';

			return $output;

		}

		/**
		 * The element shortcode
		 *
		 * @param 	array 	$atts 		Shortcode attributes
		 * @param 	string 	$content 	Content inside shortcode
		 * @return 	string
		 **/
		public static function shortcode_item( $atts, $content = null ) {

			$atts = shortcode_atts( array(
				'prop' 		=> false,
				'element'	=> 'span'
			), $atts );

			if( ! $atts['prop'] )
				return $content;

			$output 	 = '<'. esc_html( $atts['element'] ) .' class="wp-microdata-element" itemprop="'. esc_html( $atts['prop'] ) .'">';

			$output 	.= do_shortcode( $content );

			$output 	.= '</'. esc_html( $atts['element'] ) .'>';

			return $output;
		}

		/**
		 * Add buttons to the TinyMCE-editor
		 *
		 * @return void
		 */
		public static function buttonhooks() {
		   	if ( ( current_user_can( 'edit_posts' ) || current_user_can( 'edit_pages' ) ) && get_user_option( 'rich_editing' ) ) {
		    	add_filter( 'mce_external_plugins', 	array( 'WP_Microdata', 'register_tinymce_javascript' ) );
		    	add_filter( 'mce_buttons', 				array( 'WP_Microdata', 'register_buttons' ) );
		    }
		}

		/**
		 * Register buttons
		 *
		 * @return array
		 */
		public static function register_buttons($buttons) {
		   	array_push( $buttons, 'separator', 'wp_microdata' );
		   	return $buttons;
		}

		/**
		 * Adds the JavaScript used for the grid system in the editor
		 *
		 * @return array
		 */
		public static function register_tinymce_javascript($plugin_array) {
		   	$plugin_array['wp_microdata'] = plugins_url( '/js/wp-microdata.tinymce.js', __file__ );
		   	return $plugin_array;
		}

		/**
		 * Translates the TinyMCE
		 *
		 * @return array
		 * @author 
		 **/
		public static function tinymce_add_locale($locales) {
		    $locales['wp_microdataPlugin'] = plugin_dir_path ( __FILE__ ) . 'wp-microdata.translations.php';

		    return $locales;
		}

		/**
		 * Loads the plugin text domain. 
		 * 
		 * Looks for language files in the WordPress language directory first.
		 *
		 * @return void
		 **/
		public static function load_textdomain() {

			$domain = 'wp-microdata';

		    // The "plugin_locale" filter is also used in load_plugin_textdomain()
		    $locale = apply_filters('plugin_locale', get_locale(), $domain);

		    load_textdomain( $domain, WP_LANG_DIR .'/'. $domain .'/'. $domain .'-'. $locale .'.mo' );
		    load_plugin_textdomain( $domain, FALSE, dirname(plugin_basename(__FILE__)).'/lang/' );

		}


	} // END class WP_Microdata

	// let WordPress know we're ready
	add_action( 'plugins_loaded', 'WP_Microdata::instance' );

}
/*
=== WP Microdata ===
Contributors: tormorten
Donate link: http://tormorten.no
Tags: microdata,html5,scope,itemscope,itemprop,html microdata,schema.org
Requires at least: 3.8
Tested up to: 4.2
Stable tag: 1.0

Easily add microdata elements to your posts and pages using shortcodes.

== Description ==

Lets you add blocks of microdata using shortcodes.

```

```

This is the long description. No limit, and you can use Markdown (as well as in the following sections).

For backwards compatibility, if this section is missing, the full length of the short description will be used, and
Markdown parsed.

A few notes about the sections above:

* "Contributors" is a comma separated list of wp.org/wp-plugins.org usernames
* "Tags" is a comma separated list of tags that apply to the plugin
* "Requires at least" is the lowest version that the plugin will work on
* "Tested up to" is the highest version that you've *successfully used to test the plugin*. Note that it might work on
higher versions... this is just the highest one you've verified.
* Stable tag should indicate the Subversion "tag" of the latest stable version, or "trunk," if you use \`/trunk/\` for
stable.

    Note that the \`readme.txt\` of the stable tag is the one that is considered the defining one for the plugin, so
if the \`/trunk/readme.txt\` file says that the stable tag is \`4.3\`, then it is \`/tags/4.3/readme.txt\` that'll be used
for displaying information about the plugin. In this situation, the only thing considered from the trunk \`readme.txt\`
is the stable tag pointer. Thus, if you develop in trunk, you can update the trunk \`readme.txt\` to reflect changes in
your in-development version, without having that information incorrectly disclosed about the current stable version
that lacks those changes -- as long as the trunk's \`readme.txt\` points to the correct stable tag.

    If no stable tag is provided, it is assumed that trunk is stable, but you should specify "trunk" if that's where
you put the stable version, in order to eliminate any doubt.

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload \`plugin-name.php\` to the \`/wp-content/plugins/\` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place \`<?php do_action('plugin_name_hook'); ?>\` in your templates

== Frequently Asked Questions ==

= A question that someone might have =

An answer to that question.

= What about foo bar? =

Answer to foo bar dilemma.

== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from
the directory of the stable readme.txt, so in this case, \`/tags/4.3/screenshot-1.png\` (or jpg, jpeg, gif)
2. This is the second screen shot

== Changelog ==

= 1.0 =
* A change since the previous version.
* Another change.

= 0.5 =
* List versions from most recent at top to oldest at bottom.

== Upgrade Notice ==

= 1.0 =
Upgrade notices describe the reason a user should upgrade. No more than 300 characters.

= 0.5 =
This version fixes a security related bug. Upgrade immediately.

== Arbitrary section ==

You may provide arbitrary sections, in the same format as the ones above. This may be of use for extremely complicated
plugins where more information needs to be conveyed that doesn't fit into the categories of "description" or
"installation." Arbitrary sections will be shown below the built-in sections outlined above.

== A brief Markdown Example ==

Ordered list:

1. Some feature
1. Another feature
1. Something else about the plugin

Unordered list:

* something
* something else
* third thing

Here's a link to [WordPress](http://wordpress.org/ "Your favorite software") and one to [Markdown's Syntax Documentation][markdown syntax].
Titles are optional, naturally.

[markdown syntax]: http://daringfireball.net/projects/markdown/syntax
            "Markdown is what the parser uses to process much of the readme file"

Markdown uses email style notation for blockquotes and I've been told:
> Asterisks for *emphasis*. Double it up for **strong**.

\`<?php code(); // goes in backticks ?>\`
*/
