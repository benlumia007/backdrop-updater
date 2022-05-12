<?php
/**
 * Engine class.
 *
 * A wrapper around the `View` class with methods for quickly working with views
 * without having to manually instantiate a view object.  It's also useful
 * because it passes an `$engine` variable to all views.
 *
 * @package   Backdrop Core
 * @copyright Copyright (C) 2019-2021. Benjamin Lu
 * @author    Benjamin Lu ( https://getbenonit.com )
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Define namespace
 */
namespace Benlumia007\Backdrop\View\Engine;
use Benlumia007\Backdrop\Proxies\App;
use Benlumia007\Backdrop\View\View\Component as View;

/**
 * Egine class
 * 
 * @since  3.0.0
 * @access public
 */
class Component {
	/**
	 * Returns a View object.
	 *
	 * @since  3.0.0
	 * @access public
	 * @param  string            $name
	 * @param  array|string      $slugs
	 * @return View
	 */
	public function view( $name, $slugs = [] ) {

		return App::resolve( View::class, compact( 'name', 'slugs' ) );
	}

	/**
	 * Outputs a view template.
	 *
	 * @since  3.0.0
	 * @access public
	 * @param  string            $name
	 * @param  array|string      $slugs
	 * @return void
	 */
	public function display( $name, $slugs = [] ) {

		$this->view( $name, $slugs )->display();
	}

	/**
	 * Returns a view template as a string.
	 *
	 * @since  3.0.0
	 * @access public
	 * @param  string            $name
	 * @param  array|string      $slugs
	 * @return string
	 */
	public function render( $name, $slugs = [] ) {

		return $this->view( $name, $slugs )->render();
	}
}