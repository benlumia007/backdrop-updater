<?php
/**
 * Backdrop Core ( src/Tools/ServiceProvider.php )
 *
 * @package   Backdrop Core
 * @copyright Copyright (C) 2019-2021. Benjamin Lu
 * @author    Benjamin Lu ( https://getbenonit.com )
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Define namespace
 */
namespace Benlumia007\Backdrop\FontAwesome;
use Benlumia007\Backdrop\Tools\ServiceProvider;
use Benlumia007\Backdrop\FontAwesome\Component;

/**
 * Attr provider class.
 *
 * @since  3.0.0
 * @access public
 */
class Provider extends ServiceProvider {

	/**
	 * Binds the implementation of the attributes contract to the container.
	 *
	 * @since  3.0.0
	 * @access public
	 * @return void
	 */
	public function register() {

		$this->app->bind( Component::class );

		$this->app->alias( Component::class, 'fontawesome' );
    }
    
    public function boot() {
        $this->app->resolve( 'fontawesome' )->boot();
    }
}