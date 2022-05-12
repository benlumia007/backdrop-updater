<?php
/**
 * Renderable contract.
 * 
 * Renderable classes should be implemented by a `render()` method.
 * This method should return HTML strings to the screen.
 *
 * @package   Backdrop
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright Copyright (C) 2019-2021. Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Benlumia007\Backdrop\Contracts;

/**
 * Displayable interface
 * 
 * @since  3.0.0
 * @access public
 */
interface Renderable {
    /**
	 * Return a HTML string for output.
	 *
	 * @since  3.0.0
	 * @access public
	 * @return void
	 */
	public function render();
}