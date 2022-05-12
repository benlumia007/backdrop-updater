<?php
/**
 * Backdrop Core ( src/Template/Template/Templates.php )
 *
 * @package   Backdrop Core
 * @copyright Copyright (C) 2019-2021. Benjamin Lu
 * @author    Benjamin Lu ( https://getbenonit.com )
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Define namespace
 */
namespace Benlumia007\Backdrop\Template\Manager;
use Benlumia007\Backdrop\Tools\Collection;
use function Benlumia007\Backdrop\Template\path;

/**
 * Template collection class.
 *
 * @since  3.0.0
 * @access public
 */
class Templates extends Collection {

	/**
	 * Add a new custom template.
	 *
	 * @since  3.0.0
	 * @access public
	 * @param  string  $name
	 * @param  mixed   $value
	 * @return void
	 */
	 public function add( $name, $value ) {
		$path = ltrim( trailingslashit( path( 'templates' ) ) );

		$name = $path . $name;

		parent::add( $name, new Template( $name, $value ) );
	}
}