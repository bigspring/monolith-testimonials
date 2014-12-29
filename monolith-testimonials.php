<?php
/*
 * Plugin Name: monolith_testimonials
 * Version: 1.0
 * Plugin URI: http://www.hughlashbrooke.com/
 * Description: This is your starter template for your next WordPress plugin.
 * Author: Hugh Lashbrooke
 * Author URI: http://www.hughlashbrooke.com/
 * Requires at least: 4.0
 * Tested up to: 4.0
 *
 * Text Domain: monolith-testimonials
 * Domain Path: /lang/
 *
 * @package WordPress
 * @author Hugh Lashbrooke
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Load plugin class files
require_once( 'includes/class-monolith-testimonials.php' );
require_once( 'includes/class-monolith-testimonials-settings.php' );

// Load plugin libraries
require_once( 'includes/lib/class-monolith-testimonials-admin-api.php' );
require_once( 'includes/lib/class-monolith-testimonials-post-type.php' );
require_once( 'includes/lib/class-monolith-testimonials-taxonomy.php' );

/**
 * Returns the main instance of monolith_testimonials to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object monolith_testimonials
 */
function monolith_testimonials () {
	$instance = monolith_testimonials::instance( __FILE__, '1.0.0' );

	if ( is_null( $instance->settings ) ) {
		$instance->settings = monolith_testimonials_Settings::instance( $instance );
	}

	return $instance;
}

monolith_testimonials();
