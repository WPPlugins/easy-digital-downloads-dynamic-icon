<?php
/**
 * Plugin Name:     Easy Digital Downloads - Dynamic Icon
 * Description:     Adds a dynamic favicon to the EDD shopping cart
 * Version:         1.1.0
 * Author:          Daniel J Griffiths
 * Author URI:      http://section214.com
 * Text Domain:     edd-dynamic-icon
 *
 * @package         EDD\DynamicIcon
 * @author          Daniel J Griffiths <dgriffiths@section214.com>
 */


// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) {
	exit;
}


if( ! class_exists( 'EDD_Dynamic_Icon' ) ) {


	/**
	 * Main EDD_Dynamic_Icon class
	 *
	 * @since       1.0.0
	 */
	class EDD_Dynamic_Icon {


		/**
		 * @var         EDD_Dynamic_Icon $instance The one true EDD_Dynamic_Icon
		 * @since       1.0.0
		 */
		private static $instance;


		/**
		 * Get active instance
		 *
		 * @access      public
		 * @since       1.0.0
		 * @return      self::$instance The one true EDD_Dynamic_Icon
		 */
		public static function instance() {
			if( ! self::$instance ) {
				self::$instance = new EDD_Dynamic_Icon();
				self::$instance->setup_constants();
				self::$instance->includes();
				self::$instance->load_textdomain();
				self::$instance->hooks();
			}

			return self::$instance;
		}


		/**
		 * Setup plugin constants
		 *
		 * @access      private
		 * @since       1.0.0
		 * @return      void
		 */
		private function setup_constants() {
			// Plugin version
			define( 'EDD_DYNAMIC_ICON_VER', '1.1.0' );

			// Plugin path
			define( 'EDD_DYNAMIC_ICON_DIR', plugin_dir_path( __FILE__ ) );

			// Plugin URL
			define( 'EDD_DYNAMIC_ICON_URL', plugin_dir_url( __FILE__ ) );
		}


		/**
		 * Include necessary files
		 *
		 * @access      private
		 * @since       1.0.0
		 * @return      void
		 */
		private function includes() {
			// Load core files
			require_once EDD_DYNAMIC_ICON_DIR . 'includes/scripts.php';

			if( is_admin() ) {
				require_once EDD_DYNAMIC_ICON_DIR . 'includes/admin/settings/register.php';
			}
		}


		/**
		 * Run action and filter hooks
		 *
		 * @access      private
		 * @since       1.0.0
		 * @return      void
		 */
		private function hooks() {
			// Add favicon
			add_action( 'wp_head', array( $this, 'add_favicon' ) );
		}


		/**
		 * Internationalization
		 *
		 * @access      public
		 * @since       1.0.0
		 * @return      void
		 */
		public function load_textdomain() {
			// Set filter for language directory
			$lang_dir = dirname( plugin_basename( __FILE__ ) ) . '/languages/';
			$lang_dir = apply_filters( 'EDD_Dynamic_Icon_language_directory', $lang_dir );

			// Traditional WordPress plugin locale filter
			$locale = apply_filters( 'plugin_locale', get_locale(), '' );
			$mofile = sprintf( '%1$s-%2$s.mo', 'edd-dynamic-icon', $locale );

			// Setup paths to current locale file
			$mofile_local  = $lang_dir . $mofile;
			$mofile_global = WP_LANG_DIR . '/edd-dynamic-icon/' . $mofile;

			if( file_exists( $mofile_global ) ) {
				// Look in global /wp-content/languages/edd-dynamic-icon/ folder
				load_textdomain( 'edd-dynamic-icon', $mofile_global );
			} elseif( file_exists( $mofile_local ) ) {
				// Look in local /wp-content/plugins/edd-dynamic-icon/languages/ folder
				load_textdomain( 'edd-dynamic-icon', $mofile_local );
			} else {
				// Load the default language files
				load_plugin_textdomain( 'edd-dynamic-icon', false, $lang_dir );
			}
		}


		/**
		 * Conditionally add favicon
		 *
		 * @access      public
		 * @since       1.0.0
		 * @return      void
		 */
		public function add_favicon() {
			$favicon = edd_get_option( 'edd_dynamic_icon_favicon', false );

			if( $favicon ) {
				$type = edd_get_file_ctype( $favicon );
				echo '<link rel="icon" href="' . esc_url( $favicon ) . '" type="' . $type . '" />';
			}
		}
	}
}


/**
 * The main function responsible for returning the one true EDD_Dynamic_Icon
 * instance to functions everywhere
 *
 * @since       1.0.0
 * @return      EDD_Dynamic_Icon The one true EDD_Dynamic_Icon
 */
function EDD_Dynamic_Icon_load() {
	if( ! class_exists( 'Easy_Digital_Downloads' ) ) {
		if( ! class_exists( 'S213_EDD_Activation' ) ) {
			require_once( 'includes/class.s214-edd-activation.php' );
		}

		$activation = new S214_EDD_Activation( plugin_dir_path( __FILE__ ), basename( __FILE__ ) );
		$activation = $activation->run();
	} else {
		return EDD_Dynamic_Icon::instance();
	}
}
add_action( 'plugins_loaded', 'EDD_Dynamic_Icon_load' );
