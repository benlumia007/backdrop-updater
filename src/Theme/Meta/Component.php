<?php

namespace Benlumia007\Backdrop\Updater\Theme\Meta;
use Benlumia007\Backdrop\Contracts\Bootable;

class Component implements Bootable {
	public function boot() {
		add_action( 'add_meta_boxes', [ $this, 'theme' ] );
		add_action( 'save_post', [ $this, 'save' ], 10, 2 );
	}

	public function theme() {
		add_meta_box(
			'theme_data',
			esc_html__( 'Theme Data', 'backdrop-updater' ),
			[ $this, 'metabox' ],
			[ 'theme_repo' ],
			'normal',
			'default'
		);
	}

	public function metabox( $post ) {
		global $hook_suffix, $wp_version;
		$post_id = $post->ID;

		/* Theme ID */
		$theme_id = get_post_meta( $post_id, 'id', true );

		/* Download ZIP */
		$download_link = get_post_meta( $post_id, 'download_link', true );

		/* Version */
		$version = 'post-new.php' == $hook_suffix ? '1.0.0' : get_post_meta( $post_id, 'version', true );

		/* Theme type */
		$theme_type = fx_updater_sanitize_theme_type( get_post_meta( $post_id, 'theme_type', true ) );
		?>

		<div class="fx-upmb-fields">

			<div class="fx-upmb-field fx-upmb-id">
				<div class="fx-upmb-field-label">
					<p>
						<label for="theme_id"><?php _ex( 'Theme ID', 'themes', 'fx-updater' ); ?></label>
					</p>
				</div><!-- .fx-upmb-field-label -->
				<div class="fx-upmb-field-content">
					<p>
						<input name="id" type="text" id="theme_id" value="<?php echo esc_attr( $theme_id ); ?>"/>
					</p>
					<p class="description">
						<?php _ex( 'Your theme folder (required).', 'themes', 'fx-updater' ); ?>
					</p>
				</div><!-- .fx-upmb-field-content -->
			</div><!-- .fx-upmb-field.fx-upmb-id -->

			<div class="fx-upmb-field fx-upmb-version">
				<div class="fx-upmb-field-label">
					<p>
						<label for="fxu_version"><?php _ex( 'Version', 'themes', 'fx-updater' ); ?></label>
					</p>
				</div><!-- .fx-upmb-field-label -->
				<div class="fx-upmb-field-content">
					<p>
						<input id="fxu_version" autocomplete="off" name="version" placeholder="e.g 1.0.0" type="text" value="<?php echo fx_updater_sanitize_version( $version ); ?>">
						<span class="fx-upmb-desc"><?php _ex( 'Latest theme version (required).', 'themes', 'fx-updater' ); ?></span>
					</p>
				</div><!-- .fx-upmb-field-content -->
			</div><!-- .fx-upmb-field.fx-upmb-version-->

			<div class="fx-upmb-field fx-upmb-upload">
				<div class="fx-upmb-field-label">
					<p>
						<label for="fxu_download_link"><?php _ex( 'Theme ZIP', 'themes', 'fx-updater' ); ?></label>
					</p>
				</div><!-- .fx-upmb-field-label -->
				<div class="fx-upmb-field-content">
					<p >
						<input id="fxu_download_link" class="fx-upmb-upload-url" autocomplete="off" placeholder="http://" name="download_link" type="url" value="<?php echo esc_url_raw( $download_link ); ?>">
					</p>

					<p>
						<a href="#" class="button button-primary upload-zip"><?php _ex( 'Upload', 'themes', 'fx-updater' ); ?></a>
						<a href="#" class="button remove-zip disabled"><?php _ex( 'Remove', 'themes', 'fx-updater' ); ?></a>
					</p>
					<p class="description">
						<?php _ex( 'Input theme ZIP URL or upload it.', 'themes', 'fx-updater' ); ?>
					</p>
				</div><!-- .fx-upmb-field-content -->
			</div><!-- .fx-upmb-field.fx-upmb-upload -->

		</div><!-- .fx-upmb-form -->

		<?php
		wp_nonce_field( "fx_updater_nonce7894", "fx_updater_theme_data" );
	}

	public function save( $post_id, $post ) {
		/* Stripslashes Submitted Data */
		$request = stripslashes_deep( $_POST );

		/* Verify nonce */
		if ( ! isset( $request['fx_updater_theme_data'] ) || ! wp_verify_nonce( $request['fx_updater_theme_data'], 'fx_updater_nonce7894' ) ){
			return $post_id;
		}
		/* Do not save on autosave */
		if ( defined('DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}
		/* Check post type and user caps. */
		$post_type = get_post_type_object( $post->post_type );
		if ( 'theme_repo' != $post->post_type || !current_user_can( $post_type->cap->edit_post, $post_id ) ){
			return $post_id;
		}

		/* == THEME ID == */

		/* Get (old) saved data */
		$old_data = get_post_meta( $post_id, 'id', true );

		/* Get new submitted data and sanitize it. */
		$new_data = isset( $request['id'] ) ? esc_attr( $request['id'] ) : '';

		/* New data submitted, No previous data, create it  */
		if ( $new_data && '' == $old_data ){
			add_post_meta( $post_id, 'id', $new_data, true );
		}
		/* New data submitted, but it's different data than previously stored data, update it */
		elseif( $new_data && ( $new_data != $old_data ) ){
			update_post_meta( $post_id, 'id', $new_data );
		}
		/* New data submitted is empty, but there's old data available, delete it. */
		elseif ( empty( $new_data ) && $old_data ){
			delete_post_meta( $post_id, 'id' );
		}

		/* == ZIP FILE == */

		/* Get (old) saved data */
		$old_data = get_post_meta( $post_id, 'download_link', true );

		/* Get new submitted data and sanitize it. */
		$new_data = isset( $request['download_link'] ) ? esc_url_raw( $request['download_link'] ) : '';

		/* New data submitted, No previous data, create it  */
		if ( $new_data && '' == $old_data ){
			add_post_meta( $post_id, 'download_link', $new_data, true );
		}
		/* New data submitted, but it's different data than previously stored data, update it */
		elseif( $new_data && ( $new_data != $old_data ) ){
			update_post_meta( $post_id, 'download_link', $new_data );
		}
		/* New data submitted is empty, but there's old data available, delete it. */
		elseif ( empty( $new_data ) && $old_data ){
			delete_post_meta( $post_id, 'download_link' );
		}

		/* == VERSION == */

		/* Get (old) saved data */
		$old_data = get_post_meta( $post_id, 'version', true );

		/* Get new submitted data and sanitize it. */
		$new_data = isset( $request['version'] ) ? fx_updater_sanitize_version( $request['version'] ) : '';

		/* New data submitted, No previous data, create it  */
		if ( $new_data && '' == $old_data ){
			add_post_meta( $post_id, 'version', $new_data, true );
		}
		/* New data submitted, but it's different data than previously stored data, update it */
		elseif( $new_data && ( $new_data != $old_data ) ){
			update_post_meta( $post_id, 'version', $new_data );
		}
		/* New data submitted is empty, but there's old data available, delete it. */
		elseif ( empty( $new_data ) && $old_data ){
			delete_post_meta( $post_id, 'version' );
		}
	}
}
