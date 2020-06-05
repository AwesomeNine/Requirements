<?php
/**
 * Class TestWP
 *
 * @since   1.0.0
 * @package Awesome9\Requirements
 * @author  Awesome9 <me@awesome9.co>
 */

namespace Awesome9\Requirements\Test\Checker;

use Awesome9\Requirements\Requirements;
use Awesome9\Requirements\Checker\WP as TestedChecker;

/**
 * PHP checker test case.
 */
class TestWP extends \WP_UnitTestCase {

	public function setUp() {
		parent::setUp();
		$this->checker = new TestedChecker();
	}

	public function test_get_name_should_return_valid_name() {
		$this->assertSame( 'wp', $this->checker->get_name() );
	}

	/**
	 * @expectedException Exception
	 */
	public function test_check_should_throw_exception_if_passed_not_numeric_or_string_requirement() {
		$this->checker->check( [ '5.3' ] );
	}

	/**
	 * @doesNotPerformAssertions
	 */
	public function test_check_should_accept_numeric_or_string_requirement() {
		$this->checker->check( '5.3+hotfix' );
		$this->checker->check( '5.3' );
		$this->checker->check( 5.3 );
		$this->checker->check( 5 );
	}

	public function test_check_should_pass_when_using_the_same_version() {
		$this->checker->check( '5.3.1' );

		$this->assertEmpty( $this->checker->get_errors() );
	}

	public function test_check_should_not_pass_when_using_lower_version() {
		$this->checker->check( '8.8' );

		$this->assertNotEmpty( $this->checker->get_errors() );
	}
}
