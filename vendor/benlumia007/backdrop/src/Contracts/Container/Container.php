<?php
/**
 * Container contract.
 * 
 * Container classes should be used for storing, retrieving, and resolving
 * classes/objects passed into them.
 *
 * @package   Backdrop
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright Copyright (C) 2019-2021. Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Benlumia007\Backdrop\Contracts\Container;
use Closure;

/**
 * Container interface
 * 
 * @since  3.0.0
 * @access public
 */
interface Container {
	/**
	 * Determine if the given abstract type has been bound.
	 * 
	 * @since  3.0.0
	 * @access public
	 * @param  string $abstract
	 * @return bool
	 */
	public function bound( $abstract );

	/**
	 * Create an alias for the abstract type
	 * 
	 * @since  3.0.0
	 * @access public
	 * @param  string $abstract
	 * @param  string $alias
	 * @param  void
	 */
	public function alias( $abstract, $alias );

    /**
     * Register a binding with the container.
     * 
     * @since  3.0.0
     * @access public
     * @param  string $abstract
     * @param  mixed  $concrete
     * @param  bool   $shared
     * @return void
     */
    public function bind( $abstract, $concrete = null, $shared = false );

    /**
     * Register a binding if it hasn't already been registered.
     * 
     * @since  3.0.0
     * @access public
	 * @param  string  $abstract
	 * @param  mixed   $concrete
	 * @param  bool    $shared
	 * @return void
     */
    public function add( $abstract, $concrete = null, $shared = false );

	/**
	 * Register a shared binding in the container.
	 * 
	 * @since  3.0.0
	 * @access public
	 * @param  string $abstract
	 * @param  mixed  $concrete
	 * @return void
	 */
	public function singleton( $abstract, $concrete = null );

	 /**
	  * Extend an abstract type in the container
	  *
	  * @since  3.0.0
	  * @access public
	  * @param  string  $abstract
	  * @param  Closure $closure
	  * @return void
	  */
	  public function extend( $abstract, Closure $closure );

	/**
	 * Register an existing instance as a shared in the container.
	 * 
	 * @since  3.0.0
	 * @access public
	 * @param  string $abstract
	 * @param  mixed  $instance
	 */
	public function instance( $abstract, $instance );

	/**
	 * Get a closure to resolve the given type from the container.
	 *
	 * @since  3.0.0
	 * @access public
	 * @param  string $abstract
	 * @return object
	 */
	public function factory( $abstract );

    /**
     * Remove a binding from the container.
     * 
     * @since  3.0.0
	 * @access public
	 * @param  string  $abstract
	 * @return void
     */
    public function remove( $abstract );

	/**
	 * Resolve the given type from the container.
	 *
	 * @since  3.0.0
	 * @access public
	 * @param  string $abstract
	 * @param  array  $parameters
	 * @return mixed
	 */
    public function resolve( $abstract, array $parameters = [] );
}