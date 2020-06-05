<?php
/**
 * Class TestChecker
 *
 * @since   1.0.0
 * @package Awesome9\Requirements
 * @author  Awesome9 <me@awesome9.co>
 */

namespace Awesome9\Requirements\Test\Abstracts;

use Awesome9\Requirements\Requirements;
use Awesome9\Requirements\Abstracts\Checker;

/**
 * Abstract checker test case.
 */
class TestChecker extends \WP_UnitTestCase {

	public function setUp() {

		parent::setUp();

		$this->checker = $this->getMockBuilder( 'Awesome9\\Requirements\\Abstracts\\Checker' )
							  ->getMockForAbstractClass();

		$this->checker->name = 'test';

	}

	public function test_add_error_should_add_one_error() {

		$this->checker->add_error( 'test' );

		$this->assertSame( [ 'test' ], $this->checker->get_errors() );

	}

	public function test_add_error_should_add_two_errors() {

		$errors = [
			'test',
			uniqid(),
		];

		$this->checker->add_error( $errors[0] );
		$this->checker->add_error( $errors[1] );

		$this->assertSame( $errors, $this->checker->get_errors() );

	}

	public function test_get_errors_should_get_empty_array_if_no_error_set() {

		$this->assertSame( [], $this->checker->get_errors() );

	}

}
