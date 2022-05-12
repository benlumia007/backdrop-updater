<?php
/**
 * Engine interface
 *
 * @package   Backdrop Core
 * @copyright Copyright (C) 2019-2021. Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @author    Benjamin Lu ( https://benjlu.com )
 */

/**
 * Define namespace
 */
namespace Benlumia007\Backdrop\Contracts\View;

/**
 * Engine interface.
 * 
 * @since  3.0.0
 * @access public
 */
interface Engine {
    /**
     * Returns a View object.
     * 
     * @since  3.0.0
     * @access public
     * @param  string $name
     * @param  mixed  $slugs
     * @return View
     */
    public function view( $name, $slugs = [] );

    /**
     * Outputs a view template.
     * 
     * @since  3.0.0
     * @access public
     * @param  string $name
     * @param  mixed  $slugs
     * @return void
     */
    public function display( $name, $slugs = [] );

    /**
     * Returns a view template as a string.
     * 
     * @since  3.0.0
     * @access public
     * @param  string $name
     * @param  mixed  $slugs
     * @return void
     */
    public function render( $name, $slugs = [] );
}