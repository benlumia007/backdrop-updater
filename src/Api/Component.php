<?php

namespace Benlumia007\Backdrop\Updater\Api;
use Benlumia007\Backdrop\Contracts\Bootable;

class Component implements Bootable {
	public function boot() {
		add_filter( 'query_vars', [ $this, 'qvars' ] );
		add_filter( 'template_include', [ $this, 'include' ] ) ;
	}

	public function qvars( $vars ) {
		$vars[] = 'backdrop_updater';

		return $vars;
	}

	public function include(  $template ) {
		/* Get query var */
		$fx_updater = get_query_var( 'backdrop_updater' );

		/* Path */
		$path = trailingslashit( BACKDROP_PATH . 'src/Api/templates' );

		if( 'query_themes' == $fx_updater ){
			$template = $path . 'query_themes.php';
		}

		return $template;
	}
}
