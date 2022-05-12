<?php
/**
 * Template hierarchy service provider.
 *
 * This is the service provider for the template hierarchy. It's used to register
 * the template hierarchy with the container and boot it when needed.
 *
 * @package   Backdrop Core
 * @copyright Copyright (C) 2019-2021. Benjamin Lu
 * @author    Benjamin Lu ( https://getbenonit.com )
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Define namespace
 */
namespace Benlumia007\Backdrop\Template\Hierarchy;
use Benlumia007\Backdrop\Contracts\Template\Hierarchy as TemplateHierarchy;
use Benlumia007\Backdrop\Template\Hierarchy\Component;
use Benlumia007\Backdrop\Tools\ServiceProvider;

/**
 * Template hierarchy provider class.
 *
 * @since  3.0.0
 * @access public
 */
class Provider extends ServiceProvider {

	/**
	 * Registration callback that adds a single instance of the template
	 * hierarchy to the container.
	 *
	 * @since  3.0.0
	 * @access public
	 * @return void
	 */
	public function register() {

		$this->app->singleton( TemplateHierarchy::class, Component::class );

		$this->app->alias( TemplateHierarchy::class, 'template/hierarchy' );
	}

	/**
	 * Boots the hierarchy by firing its hooks in the `boot()` method.
	 *
	 * @since  3.0.0
	 * @access public
	 * @return void
	 */
	public function boot() {

		$this->app->resolve( 'template/hierarchy' )->boot();
	}
}