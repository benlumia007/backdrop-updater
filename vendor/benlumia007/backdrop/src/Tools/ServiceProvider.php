<?php
/**
 * Base Service Provider
 *
 * @package   Backdrop
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright Copyright (C) 2019-2021. Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Define namespace
 */
namespace Benlumia007\Backdrop\Tools;
use Benlumia007\Backdrop\Contracts\Foundation\Framework;

/**
 * Provider
 * 
 * @since  3.0.0
 * @access public
 */
abstract class ServiceProvider {
	/**
	 * Framework instance. Sub-classes should use this property to access
	 * the Framework (container) to add, remove, or resolve bindings.
	 *
	 * @since  3.0.0
	 * @access protected
	 * @var    Framework
	 */
	protected $app;

	/**
	 * Accepts the Framework and sets it to the `$app` property.
	 *
	 * @since  3.0.0
	 * @access public
	 * @param  Framework  $app
	 * @return void
	 */
	public function __construct( Framework $app ) {

		$this->app = $app;
	}

	/**
	 * Callback executed when the `Framework` class registers providers.
	 *
	 * @since  3.0.0
	 * @access public
	 * @return void
	 */
	public function register() {}

	/**
	 * Callback executed after all the service providers have been registered.
	 * This is particularly useful for single-instance container objects that
	 * only need to be loaded once per page and need to be resolved early.
	 *
	 * @since  3.0.0
	 * @access public
	 * @return void
	 */
	public function boot() {}
}