<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://test.com
 * @since      1.0.0
 *
 * @package    Samir_Post_Export
 * @subpackage Samir_Post_Export/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Samir_Post_Export
 * @subpackage Samir_Post_Export/includes
 * @author     Samir Vyas <sam.vyas81@gmail.com>
 */
class Samir_Post_Export_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'samir-post-export',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
