<?php
/**
 * Standard Advanced Google Analytics
 *
 * @package   Standard Advanced Google Analytics
 * @author    8BIT <info@8bit.io>
 * @license   GPL-2.0+
 * @link      http://8bit.io
 * @copyright 2013 8BIT
 */

/**
 * Standard Advanced Google Analytics
 *
 * @package   Standard Advanced Google Analytics
 * @author    8BIT <info@8bit.io>
 */
class Standard_Advanced_Google_Analytics {

	/*--------------------------------------------------------*
	 * Attributes
	 *--------------------------------------------------------*/

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	 private static $instance = null;

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	 private $version = '1.0.0';

	/*--------------------------------------------------------*
	 * Constructor
	 *--------------------------------------------------------*/

	/**
	 * Returns an instance of this class.
	 *
	 * @since     1.0.0
	 * @return    Standard_Advanced_Google_Analytics
	 */
	 public function get_instance() {

		 // Get an instance of the
		 if( null == self::$instance ) {
			 self::$instance = new self;
		 } // end if

		 return self::$instance;

	 } // end get_instance

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	 private function __construct() {

		// Load plugin textdomain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Introduce the administration JavaScript
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		// Introduce the new admin fields
		add_action( 'admin_init', array( $this, 'load_advanced_google_analytics' ) );

		// Display the notification of where th new fields are located
		add_action( 'admin_notices', array( $this, 'activate' ) ) ;

	 } // end constructor

	/*--------------------------------------------------------*
	 * Functions
	 *--------------------------------------------------------*/

	/**
	 * Loads the plugin text domain.
	 *
	 * @since     1.0.0
	 */
	 public function load_plugin_textdomain() {

		$domain = 'standard-advanced-google-analytics';
		$locale = apply_filters( 'standard-advanced-google-analytics', get_locale(), $domain );

        load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
        load_plugin_textdomain( $domain, FALSE, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );

	} // end plugin_textdomain

	/**
	 * Loads the JavaScript responsible for placing the Advanced Google Analytics options below the default
	 * option that comes included with Standard.
	 *
	 * @since     1.0.0
	 */
	public function enqueue_admin_scripts() {

		$screen = get_current_screen();
		if ('toplevel_page_theme_options' == $screen->id ) {
			wp_enqueue_script( 'standard-advanced-google-analytics', plugins_url( 'js/admin.min.js', __FILE__ ), array( 'jquery' ), $this->version );
		} // end if

	} // end enqueue_admin_scripts

	/**
	 * Saves the version of the plugin to the database and displays an activation notice on where users
	 * can access the new options.
	 *
	 * @since     1.0.0
	 */
	public function activate() {

		if( $this->version != get_option( 'standard_advanced_google_analytics' ) ) {

			add_option( 'standard_advanced_google_analytics', $this->version );

			$html = '<div class="updated">';
				$html .= '<p>';
					$html .= __( 'The Advanced Google Analytics are available <a href="admin.php?page=theme_options&tab=standard_theme_global_options">on this page</a>.', 'standard' );
				$html .= '</p>';
			$html .= '</div><!-- /.updated -->';

			echo $html;

		} // end if

	} // end activate

	/**
	 * Deletes the option from the database. Optionally displays an error message if there is a
	 * problem deleting the option.
	 *
	 * @since     1.0.0
	 */
	public static function deactivate() {

		// Delete the Advanced Google Analytics from the Global Options
		$options = get_option( 'standard_theme_global_options' );
		foreach( $options as $key => $value ) {

			$key = strtolower( $key );
			if( 'google_analytics_domain' == $key || 'google_analytics_linker' == $key ) {
				unset( $options[ $key ] );
			} // end if

		} // end foreach
		update_option ( 'standard_theme_global_options', $options );

		// Display an error message if the option isn't properly deleted.
		if( false == delete_option( 'standard_advanced_google_analytics' ) ) {

			$html = '<div class="error">';
				$html .= '<p>';
					$html .= __( 'There was a problem deactivating the Advanced Google Analytics Plugin. Please try again.', 'standard' );
				$html .= '</p>';
			$html .= '</div><!-- /.updated -->';

			echo $html;

		} // end if/else

	} // end activate

	/*--------------------------------------------------------*
	 * Settings API
	 *--------------------------------------------------------*/

	/**
	 * Adds the two new settings fields to the Standard Theme General Options.
	 *
	 * @since     1.0.0
	 */
	public function load_advanced_google_analytics() {

		add_settings_field(
			'google_analytics_domain_name',
			__( 'Google Analytics Domain Name', 'standard' ),
			array( $this, 'display_google_analytics_domain_name' ),
			'standard_theme_global_options',
			'global'
		);

		add_settings_field(
			'google_analytics_allow_linker',
			__( 'Google Analytics Allow Linker', 'standard' ),
			array( $this, 'display_google_analytics_allow_linker' ),
			'standard_theme_global_options',
			'global'

		);

	} // end load_advanced_google_analytics

	/**
	 * Displays the option for introducing the Google Analytics Domain.
	 *
	 * @since     1.0.0
	 */
	public function display_google_analytics_domain_name() {

		$options = get_option( 'standard_theme_global_options' );

		$domain = '';
		if( isset( $options['google_analytics_domain'] ) ) {
			$domain = $options['google_analytics_domain'];
		} // end if

		echo '<input type="text" name="standard_theme_global_options[google_analytics_domain]" id="standard_theme_global_options[google_analytics_domain]" value="' . $domain . '" placeholder="' . get_bloginfo( 'url' ) . '" />';


	} // end display_google_analytics_domain_name

	/**
	 * Displays the option for introducing the Google Analytics Linker.
	 *
	 * @since     1.0.0
	 */
	public function display_google_analytics_allow_linker() {

		$options = get_option( 'standard_theme_global_options' );

		$linker = '';
		if( isset( $options['google_analytics_linker'] ) ) {
			$linker = $options['google_analytics_linker'];
		} // end if

		$html = '<label for="standard_theme_global_options[google_analytics_linker]">';
			$html .= '<input type="checkbox" name="standard_theme_global_options[google_analytics_linker]" id="standard_theme_global_options[google_analytics_linker]" value="1"' . checked( 1, $linker, false ) . ' />';
			$html .= '&nbsp;';
			$html .= __( 'Display the linker in the header', 'standard-advanced-google-analytics' );
		$html .= '</label>';

		echo $html;

	} // end google_analytics_allow_linker_display

} // end class