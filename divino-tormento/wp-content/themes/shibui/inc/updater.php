<?php

if ( ! class_exists( 'GPP_Updater' ) ) {

	/**
	 * GPP_Updater provides license checks and updates to WordPress themes or plugins.
	 * To use this script do the following:
	 * 
	 *   1. Include this file in your theme or plugin
	 *   2. Create an instance of it in your theme's functions.php or plugin file:
	 *
	 *      $license_manager = new GPP_Updater(
	 *          $product_id,        // The "slug" of the theme or plugin. This must match exactly the ZIP download slug.
	 *          $product_name,      // A pretty name for your plugin/theme. Used for settings screens.
	 *          $text_domain,       // The plugin/theme text domain for localization.
	 *          $type = 'theme',    // "theme" or "plugin" depending on which you are creating.
	 *          $plugin_file = ''   // The main file of your plugin (only needed for plugins).
	 *                              // e.g. __FILE__ if you are creating GPP_Updater from your main plugin file.
	 *       );
	 *
	 *
	 * @author Thad Allender
	 * @url https://graphpaperpress.com
	 */
	
	class GPP_Updater {

		/**
		 * The plugin prefix. Configured through the class's constructor.
		 *
		 * @var String  The prefix.
		 */
		private $prefix;

		/**
		 * The Graph Paper Press website url. Configured through the class's constructor.
		 *
		 * @var String  The url.
		 */
		private $home;

		/**
		 * The API endpoint. Configured through the class's constructor.
		 *
		 * @var String  The API endpoint.
		 */
		private $api_endpoint;

		/**
		 * The product id (slug) used for this product on the License Manager site.
		 * Configured through the class's constructor.
		 *
		 * @var int     The product id of the related product in the license manager.
		 */
		private $product_id;

		/**
		 * The name of the product using this class. Configured in the class's constructor.
		 *
		 * @var int     The name of the product (plugin / theme) using this class.
		 */
		private $product_name;

		/**
		 * The type of the installation in which this class is being used.
		 *
		 * @var string  'theme' or 'plugin'.
		 */
		private $type;

		/**
		 * The text domain of the plugin or theme using this class.
		 * Populated in the class's constructor.
		 *
		 * @var String  The text domain of the plugin / theme.
		 */
		private $text_domain;

		/**
		 * @var string  The absolute path to the plugin's main file. Only applicable when using the
		 *              class with a plugin.
		 */
		private $plugin_file;

		/**
		 * Initializes the license manager client.
		 *
		 * @param $product_id   string  The text id (slug) of the product on the license manager site
		 * @param $product_name string  The name of the product, used for menus
		 * @param $text_domain  string  Theme / plugin text domain, used for localizing the settings screens.
		 * @param $type         string  The type of project this class is being used in ('theme' or 'plugin')
		 * @param $plugin_file  string  The full path to the plugin's main file (only for plugins)
		 */
		public function __construct( $product_id, $product_name, $text_domain, $type = 'theme', $plugin_file = '' ) {

			// Store setup data
			$this->prefix = 'gpp';
			$this->home = 'https://graphpaperpress.com';
			$this->api_endpoint = $this->home . '/api/license-manager/v1/';
			$this->product_id = $product_id;
			$this->product_name = $product_name;
			$this->text_domain = $text_domain;
			$this->type = $type;
			$this->plugin_file = $plugin_file;

			// Add actions required for the class's functionality.
			// NOTE: Everything should be done through actions and filters.
			if ( is_admin() ) {
				// Add the menu screen for inserting license information
				add_action( 'admin_menu', array( $this, 'add_license_settings_page' ) );
				add_action( 'admin_init', array( $this, 'add_license_settings_fields' ) );

				// Add a nag text for reminding the user to save the license information
				add_action( 'admin_notices', array( $this, 'show_admin_notices' ) );

				if ( $type == 'theme' ) {
					// Check for updates (for themes)
					add_filter( 'pre_set_site_transient_update_themes', array( $this, 'check_for_update' ) );
				} elseif ( $type == 'plugin' ) {
					// Check for updates (for plugins)
					add_filter( 'pre_set_site_transient_update_plugins', array( $this, 'check_for_update' ) );

					// Showing plugin information
					add_filter( 'plugins_api', array( $this, 'plugins_api_handler' ), 10, 3 );
				}

				// Activation and Deactivation hooks
				add_action( 'after_switch_theme', array( $this, 'activation' ) );
				register_activation_hook( __FILE__, array( $this, 'activation' ) );
				register_deactivation_hook( __FILE__, array( $this, 'deactivation' ) );
			}
		}

		/**
		 * On plugin activation, deactive old GPP updater plugins
		 */
		public function activation() {

			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			deactivate_plugins( array( '/gpp-theme-updates/gpp-theme-updates.php', '/gpp-plugin-updates/gpp-plugin-updates.php' ) );
			$this->delete_transients();
		}

		/**
		 * On plugin deactivation, delete option and cache
		 */
		public function deactivation() {

			delete_option( $this->get_settings_field_name() );
			$this->delete_transients();
		}

		/**
		 * Delete transients so updates work as expected
		 */
		private function delete_transients() {

			delete_transient( $this->prefix . '_license_cache' );
			delete_transient( 'update_themes' );
			delete_transient( 'update_plugins' );
		}

		//
		// LICENSE SETTINGS
		//

		/**
		 * Creates the settings items for entering license information (email + license key).
		 *
		 * NOTE:
		 * If you want to move the license settings somewhere else (e.g. your theme / plugin
		 * settings page), we suggest you override this function in a subclass and
		 * initialize the settings fields yourself. Just make sure to use the same
		 * settings fields so that GPP_Updater can still find the settings values.
		 */
		public function add_license_settings_page() {
			$title = __( 'GPP License', $this->text_domain );

			add_options_page(
				$title,
				$title,
				'read',
				$this->get_settings_page_slug(),
				array( $this, 'render_licenses_menu' )
			);
		}

		/**
		 * Creates the settings fields needed for the license settings menu.
		 */
		public function add_license_settings_fields() {
			$settings_group_id = $this->prefix . '-license-settings-group';
			$settings_section_id = $this->prefix . '-license-settings-section';

			register_setting(
				$settings_group_id,
				$this->get_settings_field_name(),
				array( $this, 'license_settings_callback' )
			);

			add_settings_section(
				$settings_section_id,
				__( 'Add Your License', $this->text_domain ),
				array( $this, 'render_settings_section' ),
				$settings_group_id
			);

			add_settings_field(
				$this->prefix . '-license-email',
				__( 'License E-mail Address', $this->text_domain ),
				array( $this, 'render_email_settings_field' ),
				$settings_group_id,
				$settings_section_id
			);

			add_settings_field(
				$this->prefix . '-license-key',
				__( 'License Key', $this->text_domain ),
				array( $this, 'render_license_key_settings_field' ),
				$settings_group_id,
				$settings_section_id
			);
		}

		/**
		 * Sanitizes and returns settings.
		 * Also deletes the license transient cache.
		 * Transients are used to minimize calls to the API.
		 * 
		 * @return [type] [description]
		 */
		public function license_settings_callback( $input ) {
			$this->delete_transients();
			return $input;
		}

		/**
		 * Renders the description for the settings section.
		 */
		public function render_settings_section() {
			$html = $this->get_license_status();
			echo $html;
		}

		/**
		 * Renders the settings page for entering license information.
		 */
		public function render_licenses_menu() {
			$title = __( 'GPP License', $this->text_domain );
			$settings_group_id = $this->prefix . '-license-settings-group';

			?>
			<div class="wrap">
				<form action='options.php' method='post'>

					<h2><?php echo $title; ?></h2>

					<?php
					settings_fields( $settings_group_id );
					do_settings_sections( $settings_group_id );
					submit_button();

					?>

				</form>
			</div>
		<?php
		}

		/**
		 * Renders the email settings field on the license settings page.
		 */
		public function render_email_settings_field() {
			$settings_field_name = $this->get_settings_field_name();
			$options = get_option( $settings_field_name );
			?>
			<input type='text' name='<?php echo $settings_field_name; ?>[email]'
				   value='<?php echo $options['email']; ?>' class='regular-text'>
		<?php
		}

		/**
		 * Renders the license key settings field on the license settings page.
		 */
		public function render_license_key_settings_field() {
			$settings_field_name = $this->get_settings_field_name();
			$options = get_option( $settings_field_name );
			?>
			<input type='text' name='<?php echo $settings_field_name; ?>[license_key]'
				   value='<?php echo $options['license_key']; ?>' class='regular-text'>
		<?php
		}

		/**
		 * If the license has not been configured properly, display an admin notice.
		 */
		public function show_admin_notices() {
			// If user can not manage_options then hide message.
			if ( ! current_user_can( 'manage_options' ) ) {
				return false;
			}
			
			$options = $this->get_license_key();
			$status = $this->get_license_info();
			if ( ! $options ) : ?>
				<div class="error">
					<p>
						<?php _e( 'Please enter your email and license key to enable updates to themes and plugins from Graph Paper Press.', $this->text_domain ); ?>
						<a href="<?php echo admin_url( 'options-general.php?page=' . $this->get_settings_page_slug() ); ?>">
							<?php _e( 'Complete the setup now.', $this->text_domain ); ?>
						</a>
					</p>
				</div>
			<?php elseif ( $this->is_api_error( $status ) ) : ?>
				<div class="settings-error error">
					<p>
						<?php
							printf(
								wp_kses(
									__( 'Your <a href="%1$s">license key</a> for Graph Paper Press themes and plugins has expired or is invalid. Please <a href="%2$s" target="_blank">renew your license</a> to re-enable automatic updates.', $this->text_domain ),
									array(  'a' => array( 'href' => array(), '_target' => array(), 'class' => array() ) )
								),
								esc_url( admin_url( 'options-general.php?page=' . $this->get_settings_page_slug() ) ),
								esc_url( $this->home . '/pricing/?action=renewal' )
							);
						?>
					</p>
				</div>
			<?php else :
				return false;
			endif;
		}


		//
		// CHECKING FOR UPDATES
		//

		/**
		 * The filter that checks if there are updates to the theme or plugin
		 * using the WP License Manager API.
		 *
		 * @param $transient          mixed   The transient used for WordPress
		 *                            theme / plugin updates.
		 *
		 * @return mixed        The transient with our (possible) additions.
		 */
		public function check_for_update( $transient ) {
			if ( empty( $transient->checked ) ) {
				return $transient;
			}

			$info = $this->is_update_available();
			if ( $info !== false ) {

				if ( $this->is_theme() ) {
					// Theme update
					$theme_data = wp_get_theme();
					$theme_slug = $theme_data->get_template();

					$transient->response[$theme_slug] = array(
						'new_version' => $info->version,
						'package'     => $info->package_url,
						'url'         => $info->description_url
					);
				} else {
					// Plugin update
					$plugin_slug = plugin_basename( $this->plugin_file );

					$transient->response[$plugin_slug] = (object) array(
						'new_version' => $info->version,
						'package'     => $info->package_url,
						'slug'        => $plugin_slug
					);
				}
			}

			return $transient;
		}

		/**
		 * Checks the license manager to see if there is an update available for this theme.
		 *
		 * @return object|bool    If there is an update, returns the license information.
		 *                      Otherwise returns false.
		 */
		public function is_update_available() {
			$license_info = $this->get_license_info();

			if ( $this->is_api_error( $license_info ) ) {
				return false;
			}

			if ( version_compare( $license_info->version, $this->get_local_version(), '>' ) ) {
				return $license_info;
			}

			return false;
		}

		/**
		 * Calls the License Manager API to get the license information for the
		 * current product.
		 *
		 * @return object|bool   The product data, or false if API call fails.
		 */
		public function get_license_info() {

			$transient = $this->prefix . '_license_cache';

			// Get from transient cache
			if ( ( $info = get_transient( $transient ) ) === false ) {

				$options = get_option( $this->get_settings_field_name() );
				if ( ! isset( $options['email'] ) || ! isset( $options['license_key'] ) ) {
					// User hasn't saved the license to settings yet. No use making the call.
					return false;
				}

				$info = $this->call_api(
					'info',
					array(
						'p' => $this->product_id,
						'e' => $options['email'],
						'l' => $options['license_key']
					)
				);

				set_transient( $transient, $info, 3600 );
			}

			return $info;
		}

		/**
		 * A function for the WordPress "plugins_api" filter. Checks if
		 * the user is requesting information about the current plugin and returns
		 * its details if needed.
		 *
		 * This function is called before the Plugins API checks
		 * for plugin information on WordPress.org.
		 *
		 * @param $res      bool|object The result object, or false (= default value).
		 * @param $action   string      The Plugins API action. We're interested in 'plugin_information'.
		 * @param $args     array       The Plugins API parameters.
		 *
		 * @return object   The API response.
		 */
		public function plugins_api_handler( $res, $action, $args ) {
			if ( $action == 'plugin_information' ) {

				// If the request is for this plugin, respond to it
				if ( isset( $args->slug ) && $args->slug == plugin_basename( $this->plugin_file ) ) {
					$info = $this->get_license_info();

					$res = (object) array(
						'name'          => isset( $info->name ) ? $info->name : '',
						'version'       => $info->version,
						'slug'          => $args->slug,
						'download_link' => $info->package_url,

						'tested'        => isset( $info->tested ) ? $info->tested : '',
						'requires'      => isset( $info->requires ) ? $info->requires : '',
						'last_updated'  => isset( $info->last_updated ) ? $info->last_updated : '',
						'homepage'      => isset( $info->description_url ) ? $info->description_url : '',

						'sections'      => array(
							'description' => $info->description,
						),

						'banners'       => array(
							'low'  => isset( $info->banner_low ) ? $info->banner_low : '',
							'high' => isset( $info->banner_high ) ? $info->banner_high : ''
						),

						'external'      => true
					);

					// Add change log tab if the server sent it
					if ( isset( $info->changelog ) ) {
						$res['sections']['changelog'] = $info->changelog;
					}

					return $res;
				}
			}

			// Not our request, let WordPress handle this.
			return false;
		}


		//
		// HELPER FUNCTIONS FOR ACCESSING PROPERTIES
		//

		/**
		 * @return string   The name of the settings field storing all license manager settings.
		 */
		protected function get_settings_field_name() {
			return $this->prefix . '-license-settings';
		}

		/**
		 * @return string   The slug id of the licenses settings page.
		 */
		protected function get_settings_page_slug() {
			return $this->prefix . '-licenses';
		}

		/**
		 * A shorthand function for checking if we are in a theme or a plugin.
		 *
		 * @return bool True if this is a theme. False if a plugin.
		 */
		private function is_theme() {
			return $this->type == 'theme';
		}

		/**
		 * @return string   The theme / plugin version of the local installation.
		 */
		private function get_local_version() {
			if ( $this->is_theme() ) {
				$theme_data = wp_get_theme();

				return $theme_data->Version;
			} else {
				$plugin_data = get_plugin_data( $this->plugin_file, false );

				return $plugin_data['Version'];
			}
		}

		/**
		 * Get the license keys set in wp-admin
		 * 
		 * @return array $key
		 */
		private function get_license_key() {
			// First, check if configured in wp-config.php
			$license_email = ( defined( 'GPP_LICENSE_EMAIL' ) ) ? GPP_LICENSE_EMAIL : '';
			$license_key = ( defined( 'GPP_LICENSE_KEY' ) ) ? GPP_LICENSE_KEY : '';

			// If not found, look up from database
			if ( empty( $license_key ) || empty( $license_key ) ) {
				$options = get_option( $this->get_settings_field_name() );
				if ( $options && is_email( $options['email'] ) && ! empty( $options['license_key'] ) ) {

					$license_email = $options['email'];
					$license_key = $options['license_key'];

				} else {
					$license_email = '';
					$license_key = '';
				}
			}

			if ( strlen( $license_email ) > 0 && strlen( $license_key ) >= 8 ) {
				return array( 'key' => $license_key, 'email' => $license_email );
			}

			// No license key found
			return false;
		}

		//
		// API HELPER FUNCTIONS
		//

		/**
		 * Makes a call to the WP License Manager API.
		 *
		 * @param $action   String  The API method to invoke on the license manager site
		 * @param $params   array   The parameters for the API call
		 *
		 * @return          array   The API response
		 */
		private function call_api( $action, $params ) {
			$url = $this->api_endpoint . $action;

			// Append parameters for GET request
			$url .= '?' . http_build_query( $params );

			// Send the request
			$response = wp_remote_get( $url );
			if ( is_wp_error( $response ) ) {
				return false;
			}

			$response_body = wp_remote_retrieve_body( $response );
			$result = json_decode( $response_body );

			return $result;
		}

		/**
		 * Checks the API response to see if there was an error.
		 *
		 * @param $response mixed|object    The API response to verify
		 *
		 * @return bool     True if there was an error. Otherwise false.
		 */
		private function is_api_error( $response ) {
			if ( $response === false ) {
				return true;
			}

			if ( ! is_object( $response ) ) {
				return true;
			}

			if ( isset( $response->error ) ) {
				return true;
			}

			return false;
		}

		/**
		 * Prints the current license status.
		 * This helps users know when the license is expired on the settings page.
		 */
		private function get_license_status() {

			if ( ! $this->get_license_key() ) {
				$msg = sprintf( wp_kses( __( '<a href="%s" target="_blank">Get your license keys here</a> and paste them below to enable automatic updates.', $this->text_domain ), array(  'a' => array( 'href' => array(), '_target' => array(), 'class' => array() ) ) ), esc_url( $this->home . '/dashboard/' ) );
				return $msg;
			}

			$license_status = $this->get_license_info();
			if ( $this->is_api_error( $license_status ) ) {
				$msg = sprintf( wp_kses( __( 'Your license key for Graph Paper Press themes and plugins has expired or is invalid. Please <a href="%s" target="_blank">renew your license</a> to re-enable automatic updates.', $this->text_domain ), array(  'a' => array( 'href' => array(), '_target' => array(), 'class' => array() ) ) ), esc_url( $this->home . '/pricing/?action=renewal' ) );
			} else {
				$msg = '<span class="dashicons dashicons-yes" style="color:green;"></span> ' . __( 'Your license is valid and your account is active.', $this->text_domain );
			}

			return $msg;
		}

	}

}