<?php
/**
 * Backdrop Core ( src/Sidebar/Sidebar.php )
 *
 * @package   Backdrop Core
 * @copyright Copyright (C) 2019-2021. Benjamin Lu
 * @author    Benjamin Lu ( https://getbenonit.com )
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Define namespace
 */
namespace Benlumia007\Backdrop\Theme\Sidebar;
use Benlumia007\Backdrop\Contracts\Theme\Sidebar;

/**
 * Register Sidebar
 */
class Component implements Sidebar {
	/**
	 * $post post.
	 *
	 * @var string
	 */
	public $sidebar_id;

	/**
	 * Construct
	 *
	 * @param array $sidebar_id array.
	 */
	public function __construct( $sidebar_id = [] ) {
		$this->sidebar_id = $this->sidebars();
	}

	/**
	 * Register Custom Sidebar
	 */
	public function register() {
		foreach ( $this->sidebar_id as $key => $value ) {
			$this->create( $value['name'], $key, $value['desc'] );
		}
	}

	/**
	 * Create Sidebar
	 *
	 * @param string $name outputs name.
	 * @param string $id displays id for sidebar.
	 * @param string $desc displays description.
	 */
	public function create( string $name, string $id, string $desc ) {
		$args = [
			'name'          => $name,
			'id'            => $id,
			'description'   => $desc,
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		];
		register_sidebar( $args );
	}

	public function boot() {
		add_action( 'widgets_init', [ $this, 'register' ] );
	}
}