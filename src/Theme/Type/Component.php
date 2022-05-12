<?php

namespace Benlumia007\Backdrop\Updater\Theme\Type;
use Benlumia007\Backdrop\Contracts\Bootable;

class Component implements Bootable {
	public function boot() {
		add_action( 'init', [ $this, 'theme' ] );
		add_action( 'admin_menu', [ $this, 'menu' ] );
		add_filter( 'parent_file', [ $this, 'parent' ] );
	}

	public function theme() {
		$labels = [
			'name'					=> sprintf( esc_html__( '%s', 						'backdrop-post-types' ),	'Themes' ),
			'singular_name'			=> sprintf( esc_html__( '%s', 						'backdrop-post_types' ),	'Theme' ),
			'name_admin_bar'		=> sprintf( esc_html__( '%s', 						'backdrop-post_types' ),	'Theme' ),
			'add_new'				=> sprintf( esc_html__( 'New %s', 					'backdrop-post-types' ),	'Theme' ),
			'add_new_item'			=> sprintf( esc_html__( 'Add New %s', 				'backdrop-post-types' ),	'Theme' ),
			'edit_item'				=> sprintf( esc_html__( 'Edit %s', 					'backdrop-post-types' ),	'Theme' ),
			'new_item'				=> sprintf( esc_html__( 'New %s', 					'backdrop-post-types' ),	'Theme' ),
			'view_item'				=> sprintf( esc_html__( 'View %s', 					'backdrop-post-types' ),	'Theme' ),
			'search_items'			=> sprintf( esc_html__( 'Search %s', 				'backdrop-post-types' ),	'Themes' ),
			'not_found'				=> sprintf( esc_html__( 'No %s Found', 				'backdrop-post-types' ),	'Themes' ),
			'not_found_in_trash' 	=> sprintf( esc_html__( 'No %s Found in Trash',		'backdrop-post-types' ),	'Themes' ),
		];

		$args = [
			'labels' => $labels,
			'public' => true,
			'has_archive'  => true,
			'menu_icon'    => 'dashicons-category',
			'show_ui'      => true,
			'show_in_rest' => true,
			'show_in_menu' => false,
			'supports'     => [ 'title' ],
			'rewrite'      => false
		];

		register_post_type( 'theme_repo', $args );
	}

	public function menu() {
		$theme = get_post_type_object( 'theme_repo' );

		add_submenu_page(
			'backdrop_updater',
			$theme->labels->name,
			$theme->labels->menu_name,
			$theme->cap->edit_posts,
			'edit.php?post_type=theme_repo'
		);
	}

	public function parent() {
		global $current_screen, $self;
		$parent_file = '';
		if ( in_array( $current_screen->base, array( 'post', 'edit' ) ) && 'theme_repo' == $current_screen->post_type ) {
			$parent_file = 'backdrop_updater';
		}
		return $parent_file;
	}
}
