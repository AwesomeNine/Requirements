<?php
/**
 * Class TestPlugins
 *
 * @since   1.0.0
 * @package Awesome9\Requirements
 * @author  Awesome9 <me@awesome9.co>
 */

namespace Awesome9\Requirements\Test\Checker;

use phpmock\Mock;
use phpmock\MockBuilder;
use Awesome9\Requirements\Requirements;
use Awesome9\Requirements\Checker\Plugins as TestedChecker;

/**
 * Plugins checker test case.
 */
class TestPlugins extends \WP_UnitTestCase {

	public function setUp() {
		parent::setUp();
		$this->checker = new TestedChecker();
	}

	public function bad_params() {
		return [
			[ '5.3' ],
			[ 1 ],
			[ true ],
		];
	}

	public function test_get_name_should_return_valid_name() {
		$this->assertSame( 'plugins', $this->checker->get_name() );
	}

	/**
	 * @dataProvider bad_params
	 * @expectedException Exception
	 */
	public function test_check_should_throw_exception_if_passed_not_array( $param ) {
		$this->checker->check( $param );
	}

	public function test_check_should_fail_if_at_least_one_required_plugin_is_not_active() {
		$this->checker->check( [
			[ 'file' => 'plugin-two/plugin-two.php', 'name' => 'Plugin Two' ],
		] );

		$errors = $this->checker->get_errors();

		$this->assertNotEmpty( $errors );
		$this->assertCount( 1, $errors );
		$this->assertContains( 'Plugin Two', $errors[0] );
	}

	public function test_check_should_fail_if_two_required_plugins_are_not_active() {
		$this->checker->check( [
			[ 'file' => 'plugin-one/plugin-one.php', 'name' => 'Plugin One' ],
			[ 'file' => 'plugin-two/plugin-two.php', 'name' => 'Plugin Two' ],
		] );

		$errors = $this->checker->get_errors();

		$this->assertNotEmpty( $errors );
		$this->assertCount( 2, $errors );
		$this->assertContains( 'Plugin One', $errors[0] );
		$this->assertContains( 'Plugin Two', $errors[1] );
	}
}
