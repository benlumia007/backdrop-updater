<?php
/**
 * Backdrop Core ( src/Menu/Menu.php )
 *
 * @package   Backdrop Core
 * @copyright Copyright (C) 2019-2021. Benjamin Lu
 * @author    Benjamin Lu ( https://getbenonit.com )
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Define namespace
 */
namespace Benlumia007\Backdrop\Theme\Menu;
use Benlumia007\Backdrop\Contracts\Theme\Menu;

/**
 * Regiser Menu Class
 * 
 * @since  3.0.0
 * @access public
 */
class Component implements Menu {
    /**
     * $menu_id
     * 
     * @since  3.0.0
     * @access public
     * @return string $menu_id
     */
    public $menu_id;

    public function __construct( $menu_id = [] ) {
        $this->menu_id = $this->menus();
    }

    /**
     * Register Menus
     * 
     * @since  3.0.0
     * @access public
     * @return void
     */
    public function register() {
        foreach ( $this->menu_id as $key => $value ) {
            $this->create( $value, $key );
        }
    }

	/**
	 * Create Menus
	 *
	 * @param string $name outputs name.
	 * @param string $id output id.
	 */
	public function create( string $name, string $id ) {
		$args = apply_filters( 'backdrop/nav/menus', [
			$id => $name,
		] );

		register_nav_menus( $args );
	}

	public function boot() {
		add_action( 'after_setup_theme', [ $this, 'register' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue' ] );
	}
}