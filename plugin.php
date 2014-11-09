<?php
/*
Plugin Name: WPiwik@Yourls
Plugin URI: http://yourls.org/
Description: Track all redirection to a wordpress blog with <a href="http://piwik.org/">Piwik</a>. Tracks IP and custom variables. Includes "Don't Log Bots" from OZH
Version: 1.0
Author: maphy-psd
Author URI: http://maphy-berlin.de
*/

// No direct call
if( !defined( 'YOURLS_ABSPATH' ) ) die();

// Register our plugin admin page
yourls_add_action( 'plugins_loaded', 'psd_wpiwik_at_yourls_admin_page' );

function psd_wpiwik_at_yourls_admin_page() {
	yourls_register_plugin_page( 'wpiwik_at_yourls', 'WPiwik@Yourls', 'psd_wpiwik_at_yourls_adminpage_do_page' );
	// parameters: page slug, page title, and function that will display the page itself
}

// Display admin page
function psd_wpiwik_at_yourls_adminpage_do_page() {

	// Check if a form was submitted
	if( isset( $_POST['wpiwik_option'] ) ) {
		// Check nonce
		yourls_verify_nonce( 'wpiwik_at_yourls' );
		
		// Process form
		psd_wpiwik_at_yourls_update_option();
	}

	// Get value from database
	$wpiwik_option = yourls_get_option( 'wpiwik_option' );
	
	// Create nonce
	$nonce = yourls_create_nonce( 'wpiwik_at_yourls' );

	echo <<<HTML
		<h2>WPiwik@Yourls</h2>
		<p>This plugin stores the WP URL and Piwik ID in the option database</p>
		<form method="post">
		<input type="hidden" name="nonce" value="$nonce" />
		<p><label for="wp_site_option">Enter the Wordpress URL</label> <input type="text" id="wp_site_option" name="wp_site_option" value="$wpiwik_option[wp_site_option]$wp_site_option" /></p>
		<p><input type="submit" value="Update WP Site" /></p>
		</form>

HTML;
}

// Update option in database
function psd_wpiwik_at_yourls_update_option() {
	$in = $_POST['wpiwik_option'];
	
	if( $in ) {
		// Validate wpiwik_option. ALWAYS validate and sanitize user input.
		// Here, we want a string
		$in = intval( $in);
		
		// Update value in database
		yourls_update_option( 'wpiwik_option', $in );
	}
}

// function mp_yourls_piwiktrack_wp() {
// // Use this to get the destination
	// $destination = yourls_get_keyword_longurl($keyword);
	// $wpsite   = $_POST['wp_site_option'];

	
		// // Track Wordpress Visit	
		// if (strpos($destination, $wpsite) === false) {}
		// else {
	// echo <<<HTML
		// <script type="text/javascript">
				 // var piwikTracker = Piwik.getTracker("https://statistik.maphy-berlin.de/piwik.php", 1);
				// piwikTracker.setReferrerUrl($page_url);
		// </script>
// HTML;
		
// }

// }

			// // $pt2 = new PiwikTracker(1);
			// // $pt2->setTokenAuth($piwik_config[token]);
			// // $pt2->enableCookies();
			// // if ( strlen(trim( $pt2->getVisitorId())) == 0 ) {
				// // $pt2->setVisitorId($pt2->getVisitorId());
			// // } else {
				// // $pt2->setVisitorId( substr(md5( time() ), 0, 16));
				// // }			
			// // $pt2->setUrl($destination);
			// // $pt2->setUrlReferrer($page_url);
			// // $pt2->setIp($ip);
			// // $pt2->setCustomVariable(1, 'Yourls Keyword', $keyword, 'page');
			// // $pt2->setCustomVariable(2, 'App', 'YOURLS trunca.de', 'visit');
			// // @$pt2->doTrackPageView($title);