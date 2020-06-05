<?php
/**
 * Theme Requirement class
 *
 * @since   1.0.0
 * @package Awesome9\Requirements
 * @author  Awesome9 <me@awesome9.co>
 */

namespace Awesome9\Requirements\Checker;

use Awesome9\Requirements\Abstracts;

/**
 * Theme Checker class
 */
class Themes extends Abstracts\Checker {

	/**
	 * Checker name
	 *
	 * @var string
	 */
	protected $name = 'themes';

	/**
	 * Checks if the requirement is met
	 *
	 * @since  1.0.0
	 *
	 * @throws \Exception When provided value is not an array with keys: slug, name.
	 *
	 * @param  mixed $value Value to check against.
	 */
	public function check( $value ) {
		if ( ! is_array( $value ) ) {
			throw new \Exception( __( 'Theme Check requires array parameter with keys: slug, name', 'awesome9-requirements' ) );
		}

		if ( ! array_key_exists( 'slug', $value ) || ! array_key_exists( 'name', $value ) ) {
			throw new \Exception( __( 'Theme Check requires array parameter with keys: slug, name', 'awesome9-requirements' ) );
		}

		$theme = wp_get_theme();

		if ( $theme->get_template() !== $value['slug'] ) {
			$this->add_error(
				sprintf(
					// Translators: theme name.
					__( 'Required theme: %s', 'awesome9-requirements' ),
					$value['name']
				)
			);
		}
	}
}
