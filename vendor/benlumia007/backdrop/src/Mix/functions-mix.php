<?php

namespace Benlumia007\Backdrop\Mix;
use Benlumia007\Backdrop\App;

function asset( $path ) {

	// Get the Laravel Mix manifest.
	$manifest = App::resolve( 'backdrop/mix' );

	// Make sure to trim any slashes from the front of the path.
	$path = '/' . ltrim( $path, '/' );

	if ( $manifest && isset( $manifest[ $path ] ) ) {
		$path = $manifest[ $path ];
	}

	return get_theme_file_uri( 'public' . $path );
}
