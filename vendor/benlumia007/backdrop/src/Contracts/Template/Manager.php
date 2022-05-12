<?php
/**
 * Backdrop Core ( src/Contracts/Template/Template.php )
 *
 * @package   Backdrop Core
 * @copyright Copyright (C) 2019-2021. Benjamin Lu
 * @license   GNU General PUblic License v2 or later ( https://www.gnu.org/licenses/gpl-2.0.html )
 * @author    Benjamin Lu ( https://getbenonit.com )
 */

/**
 * Define namespace
 * 
 * @since  3.0.0
 * @access public
 */
namespace Benlumia007\Backdrop\Contracts\Template;
use Benlumia007\Backdrop\Contracts\Bootable;

/**
 * Template interface.
 * 
 * @since  3.0.0
 * @access public
 */
interface Manager {
    	/**
	 * Returns the filename relative to the templates location.
	 *
	 * @since  3.0.0
	 * @access public
	 * @return string
	 */
	public function filename();

	/**
	 * Returns the internationalized text label for the template.
	 *
	 * @since  3.0.0
	 * @access public
	 * @return string
	 */
	public function label();

	/**
	 * Conditional function to check what type of template this is.
	 *
	 * @since  3.0.0
	 * @access public
	 * @return bool
	 */
	public function isType( $type );

	/**
	 * Conditional function to check if the template has a specific subtype.
	 *
	 * @since  3.0.0
	 * @access public
	 * @return bool
	 */
	public function hasSubtype( $subtype );

	/**
	 * Conditional function to check if the template is for a post type.
	 *
	 * @since  3.0.0
	 * @access public
	 * @return bool
	 */
	public function forPostType( $type );
}