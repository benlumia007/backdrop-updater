<?php
/**
 * Backdrop Core
 *
 * @package   Backdrop Core
 * @copyright Copyright (C) 2019-2021. Benjamin Lu
 * @license   GNU General Public License v2 or later ( https://www.gnu.org/licenses/gpl-2.0.html )
 * @author    Benjamin Lu ( https://getbenonit.com )
 */

/**
 * Define namespace
 */
namespace Benlumia007\Backdrop\Theme;
use function Benlumia007\Backdrop\Template\path;

/**
 * Add Post Type Support
 */
function post_type_support() {
    add_post_type_support( 'page', 'excerpt' );
}

/**
 * Add Comment Templates
 */
function comments_template( $template ) {
	$templates = [];
    $path = path();

	// Allow for custom templates entered into comments_template( $file ).
	$template = str_replace( trailingslashit( get_stylesheet_directory() ), '', $template );

	$template = $path . $template;

	if ( 'comments.php' !== $template ) {
		$templates[] = $template;
	}

	// Add a comments template based on the post type.
	$templates[] = sprintf( 'comments/%s.php', get_post_type() );

	// Add the default comments template.
	$templates[] = "{$path}/comments/default.php";
	$templates[] = 'comments.php';

	// Return the found template.
	return locate_template( $templates );
}

/**
 * Add excerpt more
 */
function excerpt_more() {
	$more = ' ...';

	return esc_html( $more );
}

/**
 * Get the Archive Title
 */
function archive_title() {
	if ( is_category() ) {
		$title = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$title = single_tag_title( '', false );
	} elseif ( is_author() ) {
		$title = get_the_author();
	} elseif ( is_year() ) {
		$title = get_the_date( _x( 'Y', 'yearly archives date format', 'backdrop' ) );
	} elseif ( is_month() ) {
		$title =get_the_date( _x( 'F Y', 'monthly archives date format', 'backdrop' ) );
	} elseif ( is_day() ) {
		$title = get_the_date( _x( 'F j Y', 'daily archives date format', 'backdrop' ) );
	} elseif ( is_post_type_archive() ) {
		$title = post_type_archive_title( '', false );
	} elseif ( is_tax() ) {
		$title = single_term_title( '', false );
	}
	return $title;
}