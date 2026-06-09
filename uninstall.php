<?php
/**
 * Uninstall handler.
 *
 * @package QuickDonate
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option( 'quickdonate_settings' );
delete_option( 'quickgive_settings' );
delete_option( 'quickdonate_db_version' );
delete_option( 'quickgive_db_version' );

global $wpdb;

$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}quickdonate_donations" );
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}quickgive_donations" );
