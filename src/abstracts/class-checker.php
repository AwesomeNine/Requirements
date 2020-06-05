<?php
/**
 * Checker abstract
 *
 * @since   1.0.0
 * @package Awesome9\Requirements
 * @author  Awesome9 <me@awesome9.co>
 */

namespace Awesome9\Requirements\Abstracts;

use Awesome9\Requirements\Interfaces\Checkable;

/**
 * Checker abstract
 */
abstract class Checker implements Checkable {

	/**
	 * Error messages
	 *
	 * @var array
	 */
	protected $errors = array();

	/**
	 * Checks if the requirement is met
	 *
	 * @since  1.0.0
	 *
	 * @param  mixed $value Value to check against.
	 * @return void
	 */
	abstract public function check( $value );

	/**
	 * Gets checker name
	 *
	 * @since  1.0.0
	 *
	 * @return string
	 */
	public function get_name() {
		return $this->name;
	}

	/**
	 * Adds error message
	 *
	 * @since  1.0.0
	 *
	 * @param  string $message Error message.
	 * @return Checker
	 */
	public function add_error( $message ) {
		$this->errors[] = $message;
		return $this;
	}

	/**
	 * Gets all errors
	 *
	 * @since  1.0.0
	 *
	 * @return array
	 */
	public function get_errors() {
		return $this->errors;
	}
}
