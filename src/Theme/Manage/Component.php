<?php

namespace Benlumia007\Backdrop\Updater\Theme\Manage;
use Benlumia007\Backdrop\Contracts\Bootable;

class Component implements Bootable {
	public function boot() {
		add_filter( 'manage_theme_repo_posts_columns', [ $this, 'columns' ] );
		add_action( 'manage_theme_repo_posts_custom_column', [ $this, 'custom' ], 10, 2 );
	}

	public function columns( $columns ) {
		unset( $columns['title'] );
		unset( $columns['date'] );
		$new_columns = array(
			'cb'           => '<input type="checkbox" />',
			'title'        => _x( 'Themes', 'plugins', 'fx-updater' ),
			'updater_info' => _x( 'Info', 'plugins', 'fx-updater' ),
		);
		$columns['updater_info'] = _x( 'Info', 'plugins', 'fx-updater' );

		return array_merge( $new_columns, $columns );
	}

	public function custom( $column, $post_id ) {
		switch( $column ) {
			case 'updater_info' :
				/* Vars */
				$status = '<span class="up-status-active">' . _x( 'Active', 'themes', 'fx-updater' ) . '</span>';
				$version = get_post_meta( $post_id, 'version', true );
				if( !$version ){
					$version = 'N/A';
					$status = '<span class="up-status-inactive">' . _x( 'Not Active', 'themes', 'fx-updater' ) . '</span>';
				}
				$package = get_post_meta( $post_id, 'download_link', true );
				if( !$package ){
					$package = 'N/A';
					$status = '<span class="up-status-inactive">' . _x( 'Not Active', 'themes', 'fx-updater' ) . '</span>';
				}
				else{
					$package = '<a href="' . esc_url( $package ) . '">' . _x( 'Download ZIP', 'themes', 'fx-updater' ) . '</a>';
				}
				$theme_id = get_post_meta( $post_id, 'id', true );
				if( !$theme_id ){
					$theme_id = 'N/A';
					$status = '<span class="group-status-inactive">' . _x( 'Not Active', 'themes', 'fx-updater' ) . '</span>';
				}
				$post_status = get_post_status( $post_id );
				if( 'publish' !== $post_status ){
					$status = '<span class="up-status-inactive">' . _x( 'Not Active', 'themes', 'fx-updater' ) . '</span>';
				}
				?>
				<div class="updater-info">
					<p>
						<span class="dashicons dashicons-update"></span>
						<?php _ex( 'Status', 'themes', 'fx-updater' ); ?>: <strong><?php echo $status; ?></strong>
					</p>
					<p>
						<span class="dashicons dashicons-admin-appearance"></span>
						<?php _ex( 'Theme ID', 'themes', 'fx-updater' ); ?>: <strong><?php echo $theme_id; ?></strong>
					</p>
					<p>
						<span class="dashicons dashicons-tag"></span>
						<?php _ex( 'Version', 'themes', 'fx-updater' ); ?>: <strong><?php echo $version; ?></strong>
					</p>
					<p>
						<span class="dashicons dashicons-media-archive"></span>
						<?php _ex( 'Package', 'themes', 'fx-updater' ); ?>: <strong><?php echo $package; ?></strong>
					</p>
				</div>
				<?php
			/* Just break out of the switch statement for everything else. */
			default :
				break;
		}
	}
}
