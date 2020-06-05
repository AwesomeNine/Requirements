<?php
/**
 * Checkable interface
 *
 * @since   1.0.0
 * @package Awesome9\Requirements
 * @author  Awesome9 <me@awesome9.co>
 */

namespace Awesome9\Requirements\Interfaces;

/**
 * Checkable interface
 */
interface Checkable {

	/**
	 * Gets checker name
	 *
	 * @since  1.0.0
	 *
	 * @return string
	 */
	public function get_name();

	/**
	 * Checks if the requirement is met
	 *
	 * @since  1.0.0
	 *
	 * @param  mixed $value Value to check against.
	 * @return void
	 */
	public function check( $value );
}
