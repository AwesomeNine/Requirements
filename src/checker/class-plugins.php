<?php
/**
 * Plugins Requirement class
 *
 * @since   1.0.0
 * @package Awesome9\Requirements
 * @author  Awesome9 <me@awesome9.co>
 */

namespace Awesome9\Requirements\Checker;

use Awesome9\Requirements\Abstracts;

/**
 * Plugins Checker class
 */
class Plugins extends Abstracts\Checker {

	/**
	 * Checker name
	 *
	 * @var string
	 */
	protected $name = 'plugins';

	/**
	 * Checks if the requirement is met
	 *
	 * @since  1.0.0
	 *
	 * @throws \Exception When provided value is not an array of arrays with keys: file*, name*, version.
	 *
	 * @param  mixed $value Value to check against.
	 */
	public function check( $value ) {
		if ( ! is_array( $value ) ) {
			throw new \Exception( __( 'Plugins Check requires array of arrays parameter with inner keys: file, name, version (optional)', 'awesome9-requirements' ) );
		}

		$active_plugins_raw = wp_get_active_and_valid_plugins();

		if ( is_multisite() ) {
			$active_plugins_raw = array_merge( $active_plugins_raw, wp_get_active_network_plugins() );
		}

		$active_plugins          = [];
		$active_plugins_versions = [];

		foreach ( $active_plugins_raw as $plugin_full_path ) {
			$plugin_file      = str_replace( WP_PLUGIN_DIR . '/', '', $plugin_full_path );
			$active_plugins[] = $plugin_file;

			if ( file_exists( $plugin_full_path ) ) {
				$plugin_api_data                         = @get_file_data( $plugin_full_path, array( 'Version' ) ); // phpcs:ignore
				$active_plugins_versions[ $plugin_file ] = $plugin_api_data[0];
			} else {
				$active_plugins_versions[ $plugin_file ] = 0;
			}
		}

		foreach ( $value as $plugin_data ) {
			if ( ! in_array( $plugin_data['file'], $active_plugins, true ) ) {
				$this->add_error(
					sprintf(
						// Translators: Plugin name.
						__( 'Required plugin: %s', 'awesome9-requirements' ),
						$plugin_data['name']
					)
				);
			} elseif ( isset( $plugin_data['version'] ) && version_compare( $active_plugins_versions[ $plugin_data['file'] ], $plugin_data['version'], '<' ) ) {
				$this->add_error(
					sprintf(
						// Translators: 1. Plugin name, 2. Required version, 3. Used version.
						__( 'Minimum required version of %1$s plugin is %2$s. Your version is %3$s', 'awesome9-requirements' ),
						$plugin_data['name'],
						$plugin_data['version'],
						$active_plugins_versions[ $plugin_data['file'] ]
					)
				);
			}
		}
	}
}
