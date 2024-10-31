<?php
/**
 * Plugin Name: No Results for Elementor
 * Plugin URI: https://smdev.au/projects
 * Description: A plugin to customise the Elementor search results page when there are no results found.
 * Version: 1.0.0
 * Author: SMDEV
 * Author URI: https://smdev.au
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * text-domain: no-results-for-elementor
 */
if (!defined('ABSPATH')) {
	exit;
} // Exit if accessed directly.

//initialise the settings page
require_once plugin_dir_path( __FILE__ ) . 'includes/elemnoresults_custom_settings.php'; 
   function smdevenr_plugin_add_settings_link( $links ) {
      $settings_link = '<a href="options-general.php?page=elemnoresults-settings-admin">' . __( 'Settings' ) . '</a>';
      array_push( $links, $settings_link );
      return $links;
   }
      $plugin = plugin_basename( __FILE__ );
      add_filter( "plugin_action_links_$plugin", 'smdevenr_plugin_add_settings_link' );
?>