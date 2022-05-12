<?php
/**
 * Container class.
 * 
 * The `Container` class handles storing objects for later use and 
 * handles single instances to avoid globals or singleton.
 *
 * @package   Backdrop
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright Copyright (C) 2019-2021. Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Benlumia007\Backdrop\Container;
use Benlumia007\Backdrop\Contracts\Container\Container as ContainerContract;
use ArrayAccess;
use Closure;
use ReflectionClass;
use ReflectionParameter;
use ReflectionUnionType;

/**
 * A simple container for objects.
 *
 * @since  3.0.0
 * @access public
 */
class Container implements ContainerContract, ArrayAccess {
	/**
	* Stored definitions of objects.
	*
	* @since  3.0.0
	* @access protected
	* @var    array
	*/
	protected $bindings = [];

	/**
	 * Array of aliases for bindings.
	 *
	 * @since  3.0.0
	 * @access protected
	 * @var    array
	 */
	protected $aliases = [];

	/**
	* Array of single instance objects.
	*
	* @since  3.0.0
	* @access protected
	* @var    array
	*/
	protected $instances = [];

	/**
	* Array of object extensions.
	*
	* @since  3.0.0
	* @access protected
	* @var    array
	*/
	protected $extensions = [];

	/**
	* Set up a new container.
	*
	* @since  3.0.0
	* @access public
	* @param  array  $definitions
	* @return void
	*/
	public function __construct( array $definitions = [] ) {
		foreach ( $definitions as $abstract => $concrete ) {
			$this->add( $abstract, $concrete );
		}
	}

	/**
	* Determine if the given abstract type has been bound.
	*
	* @since  3.0.0
	* @access public
	* @param  string  $abstract
	* @return bool
	*/
	public function bound( $abstract ) {
		return isset( $this->bindings[ $abstract ] ) || isset( $this->instances[ $abstract ] );
	}

	/**
	 * Creates an alias for an abstract type. This allows you to add alias
	 * names that are easier to remember rather than using full class names.
	 *
	 * @since  3.0.0
	 * @access public
	 * @param  string  $abstract
	 * @param  string  $alias
	 * @return void
	 */
	public function alias( $abstract, $alias ) {
		$this->aliases[ $alias ] = $abstract;
	}

	/**
	 * Add a binding. The abstract should be a key, abstract class name, or
	 * interface name. The concrete should be the concrete implementation of
	 * the abstract. If no concrete is given, its assumed the abstract
	 * handles the concrete implementation.
	 *
	 * @since  3.0.0
	 * @access public
	 * @param  string  $abstract
	 * @param  mixed   $concrete
	 * @param  bool    $shared
	 * @return void
	 */
	public function bind( $abstract, $concrete = null, $shared = false ) {
		/**
		 * Drop all of the stale instances and aliases
		 * 
		 * @since  3.0.0
		 * @access public
		 * @param  string  $abstract
		 * @return void
		 */
		unset( $this->instances[ $abstract ] );

		/**
		 * If no concrete type was given, we will simply set the concrete type to the
		 * abstract type. After, the concrete type to be registered as shared without
		 * be forced to state their classes in both  of the parameters
		 */
		if ( is_null( $concrete ) ) {
			$concrete = $abstract;
		}

		$this->bindings[ $abstract ]   = compact( 'concrete', 'shared' );

		$this->extensions[ $abstract ] = [];
	}

	/**
	* Alias for `bind()`.
	*
	* @since  3.0.0
	* @access public
	* @param  string  $abstract
	* @param  mixed   $concrete
	* @param  bool    $shared
	* @return void
	*/
	public function add( $abstract, $concrete = null, $shared = false ) {
		if ( ! $this->bound( $abstract ) ) {
			$this->bind( $abstract, $concrete, $shared );
		}
	}

	/**
	 * Add a shared binding.
	 *
	 * @since  3.0.0
	 * @access public
	 * @param  string  $abstract
	 * @param  object  $concrete
	 * @return void
	 */
	public function singleton( $abstract, $concrete = null ) {

		$this->add( $abstract, $concrete, true );
	}

	/**
	 * Extend a binding with something like a decorator class. Cannot
	 * extend resolved instancfes.
	 *
	 * @since  3.0.0
	 * @access public
	 * @param  string  $abstract
	 * @param  Closure $closure
	 * @return void
	 */
	public function extend( $abstract, Closure $closure ) {

		$abstract = $this->getAlias( $abstract );

		$this->extensions[ $abstract ][] = $closure;
	}

	/**
	 * Add an existing instance. This can be an instance of an object or a
	 * single value that should be stored.
	 *
	 * @since  3.0.0
	 * @access public
	 * @param  string  $abstract
	 * @param  mixed   $instance
	 * @return mixed
	 */
	public function instance( $abstract, $instance ) {

		$this->instances[ $abstract ] = $instance;

		return $instance;
	}

	/**
	* Alias for `resolve()`.
	*
	* @since  3.0.0
	* @access public
	* @param  string  $abstract
	* @return object
	*/
	public function factory( $abstract ) {
		return $this->resolve( $abstract );
	}

	/**
	 * Remove a binding.
	 *
	 * @since  3.0.0
	 * @access public
	 * @param  string  $abstract
	 * @return void
	 */
	public function remove( $abstract ) {

		if ( $this->bound( $abstract ) ) {

			unset( $this->bindings[ $abstract ], $this->instances[ $abstract ] );
		}
	}

	/**
	 * Resolve and return the binding.
	 *
	 * @since  3.0.0
	 * @access public
	 * @param  string  $abstract
	 * @param  array   $parameters
	 * @return mixed
	 */
	public function resolve( $abstract, array $parameters = [] ) {
		
		// Let's grab the true abstract name.
		$abstract = $this->getAlias( $abstract );

		/**
		 * if an instance of the type is currently being managed as a singleton
		 * we'll just return an existing instance instead of instantiating a new
		 * instance so the developer can keep using the same objects instance
		 * every time.
		 */
		if ( isset( $this->instances[ $abstract ] ) ) {
			return $this->instances[ $abstract ];
		}

		// Get the concrete implementation.
		$concrete = $this->getConcrete( $abstract );

		// If we can't build an object, assume we should return the value.
		if ( ! $this->isBuildable( $concrete ) ) {

			// If we don't actually have this, return false.
			if ( ! $this->bound( $abstract ) ) {
				return false;
			}

			return $concrete;
		}

		// Build the object.
		$object = $this->build( $concrete, $parameters );

		if ( ! $this->bound( $abstract ) ) {
			return $object;
		}

		// If shared instance, make sure to store it in the instances
		// array so that we're not creating new objects later.
		if ( $this->bindings[ $abstract ]['shared'] && ! isset( $this->instances[ $abstract ] ) ) {

			$this->instances[ $abstract ] = $object;
		}

		// Run through each of the extensions for the object.
		foreach ( $this->extensions[ $abstract ] as $extension ) {

			$object = new $extension( $object, $this );
		}

		// Return the object.
		return $object;
	}

	/**
	 * Checks if we're dealing with an alias and returns the abstract. If
	 * not an alias, return the abstract passed in.
	 *
	 * @since  3.0.0
	 * @access protected
	 * @param  string    $abstract
	 * @return string
	 */
	protected function getAlias( $abstract ) {

		if ( isset( $this->aliases[ $abstract ] ) ) {
			return $this->aliases[ $abstract ];
		}

		return $abstract;
	}

	/**
	 * Gets the concrete of an abstract.
	 *
	 * @since  3.0.0
	 * @access protected
	 * @param  string    $abstract
	 * @return mixed
	 */
	protected function getConcrete( $abstract ) {

		$concrete = false;
		$abstract = $this->getAlias( $abstract );

		if ( $this->bound( $abstract ) ) {
			$concrete = $this->bindings[ $abstract ]['concrete'];
		}

		return $concrete ?: $abstract;
	}

	/**
	 * Determines if a concrete is buildable. It should either be a closure
	 * or a concrete class.
	 *
	 * @since  3.0.0
	 * @access protected
	 * @param  mixed    $concrete
	 * @return bool
	 */
	protected function isBuildable( $concrete ) {

		return $concrete instanceof Closure
		       || ( is_string( $concrete ) && class_exists( $concrete ) );
	}

	/**
	 * Builds the concrete implementation. If a closure, we'll simply return
	 * the closure and pass the included parameters. Otherwise, we'll resolve
	 * the dependencies for the class and return a new object.
	 *
	 * @since  3.0.0
	 * @access protected
	 * @param  mixed  $concrete
	 * @param  array  $parameters
	 * @return object
	 */
	protected function build( $concrete, array $parameters = [] ) {

		if ( $concrete instanceof Closure ) {
			return $concrete( $this, $parameters );
		}

		$reflect = new ReflectionClass( $concrete );

		$constructor = $reflect->getConstructor();

		if ( ! $constructor ) {
			return new $concrete();
		}

		return $reflect->newInstanceArgs(
			$this->resolveDependencies( $constructor->getParameters(), $parameters )
		);
	}

	/**
	 * Resolves the dependencies for a method's parameters.
	 *
	 * @todo Handle errors when we can't solve a dependency.
	 *
	 * @since  3.0.0
	 * @access protected
	 * @param  array     $dependencies
	 * @param  array     $parameters
	 * @return array
	 */
	protected function resolveDependencies( array $dependencies, array $parameters ) {

		$args = [];

		foreach ( $dependencies as $dependency ) {

			// If a dependency is set via the parameters passed in, use it.
			if ( isset( $parameters[ $dependency->getName() ] ) ) {
				$args[] = $parameters[ $dependency->getName() ];
				continue;
			}

			// If the parameter is a class, resolve it.
			$types = $this->getReflectionTypes( $dependency );

			if ( $types ) {
				$resolved_type = false;

				foreach ( $types as $type ) {
					if ( class_exists( $type->getName() ) ) {
						$args[] = $this->resolve(
							$type->getName()
						);
						$resolved_type = true;
					}
				}

				if ( $resolved_type ) {
					continue;
				}
			}

			// Else, use the default parameter value.
			if ( $dependency->isDefaultValueAvailable() ) {
				$args[] = $dependency->getDefaultValue();
			}
		}

		return $args;
	}

	/**
	 * `ReflectionParameter::getType()` in PHP may return an instance of
	 * `ReflectionNamedType` or an `ReflectionUnionType`.  The latter class's
	 * `getTypes()` method returns an array of the former objects. This
	 * method ensures that we always get an array of `ReflectionNamedType`
	 * objects.
	 *
	 * @since  1.0.0
	 */
	protected function getReflectionTypes( ReflectionParameter $dependency ): array
	{
		$types = $dependency->getType();

		if ( ! $types ) {
			return [];
		} elseif ( class_exists( 'ReflectionUnionType' ) && $types instanceof ReflectionUnionType ) {
			return $types->getTypes();
		}

		return [ $types ];
	}

	/**
	* Sets a property via `ArrayAccess`.
	*
	* @since  3.0.0
	* @access public
	* @param  string  $name
	* @param  mixed   $value
	* @return void
	*/
	public function offsetSet( $name, $value ) {

		$this->add( $name, $value );
	}

	/**
	* Unsets a property via `ArrayAccess`.
	*
	* @since  3.0.0
	* @access public
	* @param  string  $name
	* @return void
	*/
	public function offsetUnset( $name ) {

		$this->remove( $name );
	}

	/**
	* Checks if a property exists via `ArrayAccess`.
	*
	* @since  3.0.0
	* @access public
	* @param  string  $name
	* @return bool
	*/
	public function offsetExists( $name ) {

		return $this->bound( $name );
	}

	/**
	* Returns a property via `ArrayAccess`.
	*
	* @since  3.0.0
	* @access public
	* @param  string  $name
	* @return mixed
	*/
	public function offsetGet( $name ) {

		return $this->factory( $name );
	}


	/**
	* Magic method when trying to set a property.
	*
	* @since  3.0.0
	* @access public
	* @param  string  $name
	* @param  mixed   $value
	* @return void
	*/
	public function __set( $name, $value ) {

		$this->add( $name, $value );
	}

	/**
	* Magic method when trying to unset a property.
	*
	* @since  3.0.0
	* @access public
	* @param  string  $name
	* @return void
	*/
	public function __unset( $name ) {

		$this->remove( $name );
	}

	/**
	* Magic method when trying to check if a property exists.
	*
	* @since  3.0.0
	* @access public
	* @param  string  $name
	* @return bool
	*/
	public function __isset( $name ) {

		return $this->bound( $name );
	}

	/**
	* Magic method when trying to get a property.
	*
	* @since  3.0.0
	* @access public
	* @param  string  $name
	* @return mixed
	*/
	public function __get( $name ) {

		return $this->factory( $name );
	}
}