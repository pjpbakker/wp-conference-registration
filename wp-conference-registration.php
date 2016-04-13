<?php
/**
 * Plugin Name: Conference Registration
 * Plugin URI: https://github.com/pjpbakker/wp-conference-registration
 * Description: Expsoses the Paypal API
 * Version: 1.0
 * Author: Paul Bakker
 * Author URI: https://github.com/pjpbakker
 * License: License: GPLv2 or later
 */

global $jal_db_version;
global $registration_table;
$jal_db_version = '1.0';
$registration_table = "conference_registration";

function jal_install () {
	global $wpdb;
	global $jal_db_version;
	global $registration_table;

	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix . $registration_table;

	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		name tinytext NOT NULL,
		text text NOT NULL,
		url varchar(55) DEFAULT '' NOT NULL,
		UNIQUE KEY id (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	add_option( "jal_db_version", $jal_db_version );
}

function jal_install_data() {
	global $wpdb;
	global $registration_table;

	$welcome_name = 'Mr. WordPress';
	$welcome_text = 'Congratulations, you just completed the installation!';

	$table_name = $wpdb->prefix . $registration_table;

	$wpdb->insert( 
		$table_name, 
		array( 
			'time' => current_time( 'mysql' ), 
			'name' => $welcome_name, 
			'text' => $welcome_text, 
		) 
	);
}

register_activation_hook( __FILE__, 'jal_install' );
register_activation_hook( __FILE__, 'jal_install_data' );
