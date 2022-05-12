<?php
/**
 * Collection class.
 *
 * @package   Backdrop
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright Copyright (C) 2019-2021. Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Benlumia007\Backdrop\Tools;
use ArrayObject;

/**
 * Registry class.
 *
 * @since  3.0.0
 * @access public
 */
class Collection extends ArrayObject {

	/**
	 * Add an item.
	 *
	 * @since  3.0.0
	 * @access public
	 * @param  string  $name
	 * @param  mixed   $value
	 * @return void
	 */
	public function add( $name, $value ) {

		$this->offsetSet( $name, $value );
	}

	/**
	 * Removes an item.
	 *
	 * @since  3.0.0
	 * @access public
	 * @param  string  $name
	 * @return void
	 */
	public function remove( $name ) {

		$this->offsetUnset( $name );
	}

	/**
	 * Checks if an item exists.
	 *
	 * @since  3.0.0
	 * @access public
	 * @param  string  $name
	 * @return bool
	 */
	public function has( $name ) {

		return $this->offsetExists( $name );
	}

	/**
	 * Returns an item.
	 *
	 * @since  3.0.0
	 * @access public
	 * @param  string  $name
	 * @return mixed
	 */
	public function get( $name ) {

		return $this->offsetGet( $name );
	}

	/**
	 * Returns the collection of items.
	 *
	 * @since  3.0.0
	 * @access public
	 * @return array
	 */
	public function all() {

		return $this->getArrayCopy();
	}

	/**
	 * Magic method when trying to set a property. Assume the property is
	 * part of the collection and add it.
	 *
	 * @since  3.0.0
	 * @access public
	 * @param  string  $name
	 * @param  mixed   $value
	 * @return void
	 */
	public function __set( $name, $value ) {

		$this->offsetSet( $name, $value );
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

		$this->offsetUnset( $name );
	}

	/**
	 * Magic method when trying to check if a property has.
	 *
	 * @since  3.0.0
	 * @access public
	 * @param  string  $name
	 * @return bool
	 */
	public function __isset( $name ) {

		return $this->offsetExists( $name );
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

		return $this->offSetGet( $name );
	}
}