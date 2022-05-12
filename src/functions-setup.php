<?php
/**
 * Functions
 * @since 1.0.0
**/

/**
 * Sanitize Version
 * @since 0.1.0
 */
function fx_updater_sanitize_version( $input ){
	$output = sanitize_text_field( $input );
	$output = str_replace( ' ', '', $output );
	return trim( esc_attr( $output ) );
}

/**
 * Sanitize Theme Type
 * @since 0.1.0
 */
function fx_updater_sanitize_theme_type( $input ){
	$valid_type = array( 'parent', 'child' );
	if( in_array( $input, $valid_type ) ){
		return $input;
	}
	return 'parent';
}

/**
 * Return array of date/month/year.
 * false if not valid.
 * @param $input string.
 * @since 0.1.0
 */
function fx_updater_explode_date( $input ){
	if( !$input ){
		return false;
	}
	$output = array();
	$input = sanitize_title_with_dashes( $input );
	$data = explode( '-', $input );
	if( !isset( $data[0] ) || !isset( $data[1] ) || !isset( $data[2] ) ){
		return false;
	}
	$output['year']  = $data[0];
	$output['month'] = $data[1];
	$output['day']   = $data[2];
	if( !checkdate( $output['month'], $output['day'], $output['year'] ) ){
		return false;
	}
	return $output;
}


/**
 * Format date to text string "YYYY-MM-DD" from array of year, month, date.
 * always return a value. if not valid will return current date.
 * @param $args array of year, month, and day (as key)
 * @since 0.1.0
 */
function fx_updater_format_date( $args ){
	/* current date */
	$default = array(
		'year'  => date( 'Y' ),
		'month' => date( 'm' ),
		'day'   => date( 'd' ),
	);
	$date = wp_parse_args( $args, $default );
	$date = array_map( 'esc_attr', $date );

	if( !checkdate( $date['month'], $date['day'], $date['year'] ) ){
		$year  = $default['year'];
		$month = $default['month'];
		$day   = $default['day'];
	}
	else{
		$year  = $date['year'];
		$month = $date['month'];
		$day   = $date['day'];
	}
	return sanitize_title_with_dashes( "{$year}-{$month}-{$day}" );
}


/**
 * Sanitize Section
 * @since 0.1.0
 */
function fx_updater_sanitize_plugin_section( $input ){

	/* allowed tags */
	$plugins_allowedtags = array(
		'a' => array( 'href' => array(), 'title' => array(), 'target' => array() ),
		'abbr' => array( 'title' => array() ), 'acronym' => array( 'title' => array() ),
		'code' => array(), 'pre' => array(), 'em' => array(), 'strong' => array(),
		'div' => array(), 'p' => array(), 'ul' => array(), 'ol' => array(), 'li' => array(),
		'h1' => array(), 'h2' => array(), 'h3' => array(), 'h4' => array(), 'h5' => array(), 'h6' => array(),
		'img' => array( 'src' => array(), 'class' => array(), 'alt' => array() )
	);

	$output = wp_kses( $input, $plugins_allowedtags );
	return $output;
}


/**
 * Markdown to HTML
 * @since 0.1.0
 */
function fx_updater_section_markdown_to_html( $input ){

	/* Load Markdown Parser */
	require_once( FX_UPDATER_PATH . 'includes/library/markdown.php' );

	//return wpautop( fx_updater_sanitize_plugin_section( fx_updater_markdown( $input ) ) );
	return fx_updater_markdown( $input );
}


/**
 * Query Themes
 * @since 1.0.0
 */
function fx_updater_query_themes() {

	/* Stripslash all */
	$request = stripslashes_deep( $_REQUEST );

	/* Var */
	$group = isset( $request['group'] ) ? $request['group'] : false;
	$theme = isset( $request['theme'] ) ? $request['theme'] : false;
	$themes = isset( $request['themes'] ) ? $request['themes'] : array();
	$data = array();

	/* Query Type */
	$query_type = $theme;
	if( !$query_type ){ return $data; }

	/* Query Args */
	$args = array(
		'post_type'   => 'theme_repo',
		'post_status' => 'publish',
	);
	if( 'theme' == $query_type ){
		$args['posts_per_page'] = 1;
		$args['meta_key'] = 'id';
		$args['meta_value'] = esc_attr( $theme );
	}
	elseif( 'group' == $query_type ){
		$args['posts_per_page'] = -1;
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'group_repo',
				'field'    => 'slug',
				'terms'    => sanitize_title( $group ),
			),
		);
	}

	/* WP Query */
	$the_query = new WP_Query( $args );
	if ( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			/* Get Theme Data */
			$post_id  = get_the_ID();
			$id       = get_post_meta( $post_id, 'id', true );
			$version  = get_post_meta( $post_id, 'version', true );
			$package  = get_post_meta( $post_id, 'download_link', true );
			if( $version ){
				/* Version compare */
				if( isset( $themes[$id]['Version'] ) && version_compare( $themes[$id]['Version'], $version, "<" ) ){
					$data[$id] = array(
						'theme'       => $id,
						'new_version' => $version,
						'url'         => $themes[$id]['ThemeURI'],
					);
					if( $package ){
						$data[$id]['package'] = $package;
					}
				}
				else{
					$data[$id] = array();
				}
			}
		}
	}
	wp_reset_postdata();
	return apply_filters( 'fx_updater_query_themes', $data, $request );
}
