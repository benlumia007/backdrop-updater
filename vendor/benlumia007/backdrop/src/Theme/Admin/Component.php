<?php
/**
 * Backdrop Core ( src/Component/Customize.php )
 *
 * @package   Backdrop Core
 * @copyright Copyright (C) 2019-2021. Benjamin Lu
 * @author    Benjamin Lu ( https://getbenonit.com )
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Define namespace
 */
namespace Benlumia007\Backdrop\Theme\Admin;
use Benlumia007\Backdrop\Contracts\Theme\Admin;

class Component implements Admin {
	/**
	 * menu()
	 * 
	 * @since  3.0.0
	 * @access public
	 */
	public function menu() {}

	/**
	 * callback()
	 * 
	 * @since  3.0.0
	 * @access public
	 */
	public function callback() {}

	/**
	 * tabs()
	 * 
	 * @since  3.0.0
	 * @access public
	 */
	public function tabs() {}

	/**
	 * pages()
	 * 
	 * @since  3.0.0
	 * @access public
	 */
	public function pages() {}

    public function boot() {
		add_action( 'admin_menu', array( $this, 'menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue' ), true, '1.0.0' );
    }
}