<?php
/**
 * PHP Extensions Requirement class
 *
 * @since   1.0.0
 * @package Awesome9\Requirements
 * @author  Awesome9 <me@awesome9.co>
 */

namespace Awesome9\Requirements\Checker;

use Awesome9\Requirements\Abstracts;

/**
 * PHP Extensions Checker class
 */
class PHP_Extensions extends Abstracts\Checker {

	/**
	 * Checker name
	 *
	 * @var string
	 */
	protected $name = 'php_extensions';

	/**
	 * Checks if the requirement is met
	 *
	 * @since  1.0.0
	 *
	 * @throws \Exception When provided value is not an array.
	 *
	 * @param  array $value Array of extensions.
	 */
	public function check( $value ) {
		if ( ! is_array( $value ) ) {
			throw new \Exception( __( 'PHP Extensions Check requires array parameter', 'awesome9-requirements' ) );
		}

		$missing_extensions = array();

		foreach ( $value as $extension ) {
			if ( ! extension_loaded( $extension ) ) {
				$missing_extensions[] = $extension;
			}
		}

		if ( ! empty( $missing_extensions ) ) {
			$this->add_error(
				sprintf(
					// Translators: PHP extensions.
					_n( 'Missing PHP extension: %s', 'Missing PHP extensions: %s', count( $missing_extensions ), 'awesome9-requirements' ),
					implode( ', ', $missing_extensions )
				)
			);
		}
	}
}
