<?php
/*
Plugin Name: Mobile Switcher
Plugin URI: http://metronet.no/
Description: Mobile Switcher
Author: Ryan Hellyer / Metronet
Version: 1.0
Author URI: http://metronet/
*/


// This has been abstracted to aid in turning this plugin into something useful for
// on other sites in future
define( 'MS_CHILD_THEME',  'twentyten' );
define( 'MS_PARENT_THEME', 'somechildtheme' );


/*
 * Switch to a different theme for mobile devices
 *
 * User agent detection methods based on work found in the
 * Mobble plugin by Scott Evans
 * http://wordpress.org/extend/plugins/mobble/
 *
 * Set the constants MS_CHILD_THEME and MS_PARENT_THEME
 * to define which themes are used for the mobile site
 *
 * @author Ryan Hellyer <ryan@metronet.no>
 * @since 1.0
 */
class Mobile_Switcher {

	/**
	 * Class constructor
	 */
	public function __construct() {
		
		/* Notify Google that we tend to redirect visitors based on their User-Agent string
		 * https://developers.google.com/webmasters/smartphone-sites/redirects
		 *
		 * Idea to use this was provided by Kaspars Dambis ... http://konstruktors.com/blog/wordpress/4283-mobile-redirect-plugin/
		 */
		header( 'Vary: User-Agent' );

		/*
		 * Define user agent - saves repeating the code inside each method
		 * Note: This may be better set as a private variable within the class
		 */
		$user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "";
		define( 'HTTP_USER_AGENT', $user_agent );

		/*
		 * Serve mobile theme only for mobile devices
		 * This intentionally DOES NOT serve the mobile theme for large tablets
		 */
		if ( $this->is_mobile() ) {
			add_filter( 'option_template',   array( $this, 'select_mobile_parent' ) );
			add_filter( 'option_stylesheet', array( $this, 'select_mobile_child' ) );
		}
	}

	/*
	 * Select the mobile theme
	 */
	public function select_mobile_child()  {
		return MS_CHILD_THEME;
	}

	/*
	 * Select the parent theme
	 */
	public function select_mobile_parent()  {
		return MS_PARENT_THEME;
	}



	/*
	 * Function is_iphone
	 * Detect the iPhone
	 */
	private function is_iphone() {
		return(preg_match('/iphone/i', HTTP_USER_AGENT ) );
	}
	
	/*
	 * Function is_ipad
	 * Detect the iPad
	 */
	private function is_ipad() {
		global $useragent;
		return(preg_match('/ipad/i', HTTP_USER_AGENT ) );
	}
	
	/*
	 * Function is_ipod
	 * Detect the iPod, most likely the iPod touch
	 */
	private function is_ipod() {
		return( preg_match( '/ipod/i', HTTP_USER_AGENT ) );
	}
	
	/*
	 * Function is_android
	 * Detect an android device. They *SHOULD* all behave the same
	 */
	private function is_android() {
		return( preg_match( '/android/i', HTTP_USER_AGENT ) );
	}
	
	/*
	 * Function is_blackberry
	 * Detect a blackberry device 
	 */
	private function is_blackberry() {
		return( preg_match( '/blackberry/i', HTTP_USER_AGENT ) );
	}
	
	/*
	 * Function is_opera_mobile
	 * Detect both Opera Mini and hopfully Opera Mobile as well
	 */
	private function is_opera_mobile() {
		return( preg_match( '/opera mini/i', HTTP_USER_AGENT ) );
	}
	
	/*
	 * Function is_palm
	 * Detect a webOS device such as Pre and Pixi
	*/
	private function is_palm() {
		return( preg_match( '/webOS/i', HTTP_USER_AGENT ) );
	}
	
	/*
	 * Function is_symbian
	 * Detect a symbian device, most likely a nokia smartphone
	 */
	private function is_symbian() {
		return( preg_match( '/Series60/i', HTTP_USER_AGENT ) || preg_match( '/Symbian/i', HTTP_USER_AGENT ) );
	}
	
	/*
	 * Function is_windows_mobile
	 * Detect a windows smartphone
	 */
	private function is_windows_mobile() {
		return( preg_match( '/WM5/i', HTTP_USER_AGENT ) || preg_match( '/WindowsMobile/i', HTTP_USER_AGENT ) );
	}
	
	/*
	 * Function is_lg
	 * Detect an LG phone
	 */
	private function is_lg() {
		return( preg_match( '/LG/i', HTTP_USER_AGENT ) );
	}
	
	/*
	 * Function is_motorola
	 * Detect a Motorola phone
	 */
	private function is_motorola() {
		return( preg_match( '/\ Droid/i', HTTP_USER_AGENT ) || preg_match( '/XT720/i', HTTP_USER_AGENT ) || preg_match( '/MOT-/i', HTTP_USER_AGENT ) || preg_match( '/MIB/i', HTTP_USER_AGENT ) );
	}
	
	/*
	 * Function is_nokia
	 * Detect a Nokia phone
	 */
	private function is_nokia() {
		return( preg_match( '/Series60/i', HTTP_USER_AGENT ) || preg_match( '/Symbian/i', HTTP_USER_AGENT ) || preg_match( '/Nokia/i', HTTP_USER_AGENT ) );
	}
	
	/*
	 * Function is_samsung
	 * Detect a Samsung phone
	 */
	private function is_samsung() {
		return( preg_match( '/Samsung/i', HTTP_USER_AGENT ) );
	}
	
	/*
	 * Function is_samsung_galaxy_tab
	 * Detect the Galaxy tab
	 */
	private function is_samsung_galaxy_tab() {
		return( preg_match( '/SPH-P100/i', HTTP_USER_AGENT ) );
	}
	
	/*
	 * Function is_sony_ericsson
	 * Detect a Sony Ericsson
	 */
	private function is_sony_ericsson() {
		return( preg_match( '/SonyEricsson/i', HTTP_USER_AGENT ) );
	}
	
	/*
	 * Function is_nintendo
	 * Detect a Nintendo DS or DSi
	 */
	private function is_nintendo() {
		return( preg_match( '/Nintendo DSi/i', HTTP_USER_AGENT ) || preg_match( '/Nintendo DS/i', HTTP_USER_AGENT ) );
	}
	
	/*
	 * Function is_handheld
	 * Wrapper function for detecting ANY handheld device
	 */
	private function is_handheld() {
		return( $this->is_iphone() || $this->is_ipad() || $this->is_ipod() || $this->is_android() || $this->is_blackberry() || $this->is_opera_mobile() || $this->is_palm() || $this->is_symbian() || $this->is_windows_mobile() || $this->is_lg() || $this->is_motorola() || $this->is_nokia() || $this->is_samsung() || $this->is_samsung_galaxy_tab() || $this->is_sony_ericsson() || $this->is_nintendo() );
	}
	
	/*
	 * Function is_mobile
	 * Wrapper function for detecting ANY mobile phone device
	 */
	private function is_mobile() {
		if ( $this->is_tablet() ) {
			return false;
		}  // this catches the problem where an Android device may also be a tablet device
		return( $this->is_iphone() || $this->is_ipod() || $this->is_android() || $this->is_blackberry() || $this->is_opera_mobile() || $this->is_palm() || $this->is_symbian() || $this->is_windows_mobile() || $this->is_lg() || $this->is_motorola() || $this->is_nokia() || $this->is_samsung() || $this->is_sony_ericsson() || $this->is_nintendo() );
	}
	
	/*
	 * Function is_ios
	 * Wrapper function for detecting ANY iOS/Apple device
	 */
	private function is_ios() {
		return( $this->is_iphone() || $this->is_ipad() || $this->is_ipod() );
	}
	
	/*
	 * Function is_tablet
	 * Wrapper function for detecting tablet devices (needs work)
	 */
	private function is_tablet() {
		return( $this->is_ipad() || $this->is_samsung_galaxy_tab() );
	}

}

new Mobile_Switcher;
