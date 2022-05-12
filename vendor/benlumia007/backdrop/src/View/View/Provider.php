<?php
/**
 * View service provider.
 *
 * This is the service provider for the view system. The primary purpose of
 * this is to use the container as a factory for creating views. By adding this
 * to the container, it also allows the view implementation to be overwritten.
 * That way, any custom functions will utilize the new class.
 *
 * @package   Backdrop Core
 * @copyright Copyright (C) 2019-2021. Benjamin Lu
 * @author    Benjamin Lu ( https://getbenonit.com )
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Benlumia007\Backdrop\View\View;

use Benlumia007\Backdrop\Tools\ServiceProvider;
use Benlumia007\Backdrop\View\Engine\Component as Engine;
use Benlumia007\Backdrop\Contracts\View\Engine as EngineContract;
use Benlumia007\Backdrop\Contracts\View\View   as ViewContract;

/**
 * View provider class.
 *
 * @since  3.0.0
 * @access public
 */
class Provider extends ServiceProvider {

	/**
	 * Binds the implementation of the view contract to the container.
	 *
	 * @since  3.0.0
	 * @access public
	 * @return void
	 */
	public function register() {

		// Bind the view contract.
		$this->app->bind( ViewContract::class, View::class );

		// Bind a single instance of the engine contract.
		$this->app->singleton( EngineContract::class, Engine::class );

		// Create aliases for the view and engine.
		$this->app->alias( ViewContract::class,   'view'        );
		$this->app->alias( EngineContract::class, 'view/engine' );
	}
}