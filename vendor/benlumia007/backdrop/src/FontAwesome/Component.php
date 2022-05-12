<?php
/**
 * Backdrop Core ( src/Contracts/Assets/FontAwesome.php )
 *
 * @package   Backdrop Core
 * @copyright Copyright (C) 2019-2021. Benjamin Lu
 * @author    Benjamin Lu ( https://getbenonit.com )
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Define namespace
 */
namespace Benlumia007\Backdrop\FontAwesome;
use Benlumia007\Backdrop\Contracts\Bootable;

/**
 * Regiser Menu Class
 */
class Component implements Bootable {
	/**
	 * Loads theme_enqueue();
	 *
	 * The theme_enqueue(); is used to define any scripts and styles that's going to be used part of a theme.
	 *
	 * @since  3.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue() {
		wp_enqueue_style( 'backdrop-fontawesome', get_theme_file_uri( '/vendor/benlumia007/backdrop/assets/fontawesome/css/all.css' ), array(), '1.0.0' );
    }

    public function boot() {
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
    }
}