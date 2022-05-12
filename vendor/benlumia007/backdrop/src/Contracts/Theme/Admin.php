<?php
/**
 * Backdrop Core ( src/Contracts/Admin/Admin.php )
 *
 * @package   Backdrop Core
 * @copyright Copyright (C) 2019-2021. Benjamin Lu
 * @author    Benjamin Lu ( https://getbenonit.com )
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Define namespace
 */
namespace Benlumia007\Backdrop\Contracts\Theme;
use Benlumia007\Backdrop\Contracts\Bootable;

/**
 * Admin
 */
interface Admin extends Bootable {
	/**
	 * menu()
	 * 
	 * @since  3.0.0
	 * @access public
	 */
	public function menu();

	/**
	 * callback()
	 * 
	 * @since  3.0.0
	 * @access public
	 */
	public function callback();

	/**
	 * tabs()
	 * 
	 * @since  3.0.0
	 * @access public
	 */
	public function tabs();

	/**
	 * pages()
	 * 
	 * @since  3.0.0
	 * @access public
	 */
	public function pages();
}