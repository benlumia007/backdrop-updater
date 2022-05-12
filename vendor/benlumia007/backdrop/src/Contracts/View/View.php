<?php
/**
 * View interface
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
use Benlumia007\Backdrop\Contracts\Displayable;
use Benlumia007\Backdrop\Contracts\Renderable;

/**
 * View interface.
 *
 * @since  3.0.0
 * @access public
 */
interface View extends Renderable, Displayable {

	/**
	 * Returns the array of slugs.
	 *
	 * @since  3.0.0
	 * @access public
	 * @return array
	 */
	public function slugs();

	/**
	 * Returns the absolute path to the template file.
	 *
	 * @since  3.0.0
	 * @access public
	 * @return string
	 */
	public function template();
}