<?php
/**
 * Class TestPHPExtensions
 *
 * @since   1.0.0
 * @package Awesome9\Requirements
 * @author  Awesome9 <me@awesome9.co>
 */

namespace Awesome9\Requirements\Test\Checker;

use Awesome9\Requirements\Requirements;
use Awesome9\Requirements\Checker\PHP_Extensions as TestedChecker;

/**
 * PHP checker test case.
 */
class TestPHPExtensions extends \WP_UnitTestCase {

	public function setUp() {
		parent::setUp();
		$this->checker = new TestedChecker();
	}

	public function test_get_name_should_return_valid_name() {
		$this->assertSame( 'php_extensions', $this->checker->get_name() );
	}

	/**
	 * @expectedException Exception
	 */
	public function test_check_should_throw_exception_if_passed_not_array_requirement() {
		$this->checker->check( '5.3' );
	}

	/**
	 * @doesNotPerformAssertions
	 */
	public function test_check_should_accept_numeric_or_associative_array_requirement() {
		$this->checker->check( [ 'test', 'testing' ] );
		$this->checker->check( [ 'test' => 'test', 'testing' => 'testing' ] );
	}

	public function test_check_should_pass_if_all_extensions_loaded() {
		$this->checker->check( [ 'gettext', 'mysqli' ] );
		$this->assertEmpty( $this->checker->get_errors() );
	}

	public function test_check_should_fail_if_at_least_one_extension_not_loaded() {
		$this->checker->check( [ 'gettext', 'extension2' ] );

		$errors = $this->checker->get_errors();

		$this->assertNotEmpty( $errors );
		$this->assertCount( 1, $errors );
		$this->assertContains( 'extension2', $errors[0] );
		$this->assertNotContains( 'extension1', $errors[0] );
	}

	public function test_check_should_fail_if_all_extensions_not_loaded() {
		$this->checker->check( [ 'extension1', 'extension2' ] );

		$errors = $this->checker->get_errors();

		$this->assertNotEmpty( $errors );
		$this->assertCount( 1, $errors );
		$this->assertContains( 'extension1', $errors[0] );
		$this->assertContains( 'extension2', $errors[0] );
	}
}
