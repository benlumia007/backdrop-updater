<?php

namespace Benlumia007\Backdrop\Updater\Settings;
use Benlumia007\Backdrop\Contracts\Bootable;

class Component implements Bootable {
	public function boot() {
		add_action( 'admin_menu', [ $this, 'settings' ] );
	}

	public function settings() {
		add_menu_page(
			esc_html__( 'Backdrop Updater', 'backdrop-updater' ),
			esc_html__( 'Backdrop Updater', 'backdrop-updater' ),
			'manage_options',
			'backdrop-updater',
			 [
				 $this,
				 'settings_pages',
			 ],
			'dashicons-update'
		);
	}

	public function settings_pages() {
		echo '<section class="admin-page">';
			echo "<header>";
				echo '<h1>' . esc_html__( 'Backdrop Updater', 'backdrop-updater' ) . '</h1>';
			echo "</header>";
		echo '</section>';
	}
}
