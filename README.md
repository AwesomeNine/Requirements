# Requirements

[![Awesome9](https://img.shields.io/badge/Awesome-9-brightgreen)](https://awesome9.co)
[![Latest Stable Version](https://poser.pugx.org/awesome9/requirements/v/stable)](https://packagist.org/packages/awesome9/requirements)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/awesome9/requirements.svg)](https://packagist.org/packages/awesome9/requirements)
[![Total Downloads](https://poser.pugx.org/awesome9/requirements/downloads)](https://packagist.org/packages/awesome9/requirements)
[![License](https://poser.pugx.org/awesome9/requirements/license)](https://packagist.org/packages/awesome9/requirements)

<p align="center">
	<img src="https://img.icons8.com/nolan/256/checked-2.png"/>
</p>

## 📃 About Requirements

It's a fork of [Requirements micropackage](https://github.com/micropackage/requirements) with some additional checking for auto-loading checkers.

This package allows you to test environment requirements to run your plugin.

It can test:

- PHP version
- PHP Extensions
- WordPress version
- Active plugins
- Current theme

## 💾 Installation

``` bash
composer require awesome9/requirements
```

## 🕹 Usage

## Basic usage

In the plugin main file:

```php
<?php
/*
Plugin Name: My Test Plugin
Version: 1.0.0
*/

// Composer autoload.
require_once __DIR__ . '/vendor/autoload.php' ;

$requirements = new \Awesome9\Requirements\Requirements( 'My Test Plugin', array(
	'php'                => '7.0',
	'php_extensions'     => array( 'soap' ),
	'wp'                 => '5.3',
	'dochooks'           => true,
	'plugins'            => array(
		array( 'file' => 'akismet/akismet.php', 'name' => 'Akismet', 'version' => '3.0' ),
		array( 'file' => 'hello-dolly/hello.php', 'name' => 'Hello Dolly', 'version' => '1.5' )
	),
	'theme'              => array(
		'slug' => 'twentysixteen',
		'name' => 'Twenty Sixteen'
	),
) );

/**
 * Run all the checks and check if requirements has been satisfied.
 * If not - display the admin notice and exit from the file.
 */
if ( ! $requirements->satisfied() ) {
	$requirements->print_notice();
	return;
}

// ... plugin runtime.
```

## Advanced usage

You can also define your own custom checks.

```php
<?php
class CustomCheck extends \Awesome9\Requirements\Abstracts\Checker {

	/**
	 * Checker name
	 *
	 * @var string
	 */
	protected $name = 'custom-check';

	/**
	 * Checks if the requirement is met
	 *
	 * @param  string $value Requirement.
	 * @return void
	 */
	public function check( $value ) {

		// Do your check here and if it fails, add the error.
		if ( 'something' === $value ) {
			$this->add_error( 'You need something!' );
		}

	}

}

$requirements = new \Awesome9\Requirements\Requirements( 'My Test Plugin', array(
	'custom-check' => 'something else',
) );

$requirements->register_checker( 'CustomCheck' );

$is_good = $requirements->satisfied();
```

## 📖 Changelog

[See the changelog file](./CHANGELOG.md)
