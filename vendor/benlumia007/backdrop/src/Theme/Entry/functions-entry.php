<?php
/**
 * Backdrop Core ( functions-entry.php )
 *
 * @package   Backdrop Core
 * @copyright Copyright (C) 2019-2021. Benjamin Lu
 * @author    Benjamin Lu ( https://getbenonit.com )
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Define namespace
 */
namespace Benlumia007\Backdrop\Theme\Entry;

function display_title( array $args = [] ) {
	echo render_title( $args ); 
}

function render_title( array $args = [] ) {
	$post_id = get_the_ID();
	$is_single = is_single( $post_id ) || is_page( $post_id ) || is_attachment( $post_id );

	$args = wp_parse_args( $args, [
		'text'   => '%s',
		'tag'    => $is_single ? 'h1' : 'h1',
		'link'   => ! $is_single,
		'class'  => 'entry-title',
		'before' => '',
		'after'  => ''
	] );

	$text = sprintf( $args['text'], $is_single ? single_post_title( '', false ) : the_title( '', '', false ) );

	if ( $args['link'] ) {
		$text = render_permalink( [ 'text' => $text ] );
	}

	$html = sprintf(
		'<%1$s class="%2$s">%3$s</%1$s>',
		tag_escape( $args['tag'] ),
		esc_attr( $args['class'] ),
		$text
	);

	return apply_filters( 'backdrop/theme/display/title', $args['before'] . $html . $args['after'] );
}

/**
 * Outputs the post permalink HTML.
 *
 * @since  3.0.0
 * @access public
 * @param  array  $args
 * @return void
 */
function display_permalink( array $args = [] ) {

	echo render_permalink( $args ); 
}

/**
 * Returns the post permalink HTML.
 *
 * @since  3.0.0
 * @access public
 * @param  array  $args
 * @return string
 */
function render_permalink( array $args = [] ) {

	$args = wp_parse_args( $args, [
		'text'   => '%s',
		'class'  => 'entry-permalink',
		'before' => '',
		'after'  => ''
	] );

	$url = get_permalink();

	$html = sprintf(
		'<a class="%s" href="%s">%s</a>',
		esc_attr( $args['class'] ),
		esc_url( $url ),
		sprintf( $args['text'], esc_url( $url ) )
	);

	return apply_filters( 'backdrop/theme/display/permalink', $args['before'] . $html . $args['after'] );
}

/**
 * Outputs the post author HTML.
 *
 * @since  3.0.0
 * @access public
 * @param  array  $args
 * @return void
 */
function display_author( array $args = [] ) {

	echo render_author( $args );
}

function render_author( array $args = [] ) {
	$args = wp_parse_args( $args, [
		'text'   => '%s',
		'class'  => 'entry-author',
		'link'   => true,
		'before' => '',
		'after'  => ''
	] );

	$author = get_the_author();

	if ( $args['link'] ) {
		$url = get_author_posts_url( get_the_author_meta( 'ID' ) );

		$author = sprintf(
			'<a class="entry__author-link" href="%s">%s</a>',
			esc_url( $url ),
			$author
		);
	}

	$html = sprintf( '<i class="fas fa-user"></i><span class="%s">%s</span>', esc_attr( $args['class'] ), $author );

	return apply_filters( 'backdrop/theme/display/author', $args['before'] . $html . $args['after'] );
}

/**
 * Outputs the post date HTML.
 *
 * @since  3.0.0
 * @access public
 * @param  array  $args
 * @return void
 */
function display_date( array $args = [] ) {

	echo render_date( $args ); // phpcs:ignore
}

/**
 * Returns the post date HTML.
 *
 * @since  3.0.0
 * @access public
 * @param  array  $args
 * @return string
 */
function render_date( array $args = [] ) {

	$args = wp_parse_args( $args, [
		'text'   => '%s',
		'class'  => 'entry-published',
		'format' => '',
		'before' => '',
		'after'  => ''
	] );

	$html = sprintf(
		'<i class="fas fa-calendar-alt"></i><time class="%s" datetime="%s">%s</time>',
		esc_attr( $args['class'] ),
		esc_attr( get_the_date( DATE_W3C ) ),
		sprintf( $args['text'], get_the_date( $args['format'] ) )
	);

	return apply_filters( 'backdrop/theme/display/date', $args['before'] . $html . $args['after'] );
}

/**
 * Outputs the post comments link HTML.
 *
 * @since  3.0.0
 * @access public
 * @param  array  $args
 * @return void
 */
function display_comments_link( array $args = [] ) {

	echo render_comments_link( $args ); // phpcs:ignore
}

/**
 * Returns the post comments link HTML.
 *
 * @since  3.0.0
 * @access public
 * @param  array  $args
 * @return string
 */
function render_comments_link( array $args = [] ) {

	$args = wp_parse_args( $args, [
		'zero'   => false,
		'one'    => false,
		'more'   => false,
		'class'  => 'entry-comments',
		'before' => '',
		'after'  => ''
	] );

	$number = get_comments_number();

	if ( 0 == $number && ! comments_open() && ! pings_open() ) {
		return '';
	}

	$url  = get_comments_link();
	$text = get_comments_number_text( $args['zero'], $args['one'], $args['more'] );

	$html = sprintf(
		'<i class="fas fa-comment"></i><a class="%s" href="%s">%s</a>',
		esc_attr( $args['class'] ),
		esc_url( $url ),
		$text
	);

	return apply_filters( 'backdrop/theme/display/comments/link', $args['before'] . $html . $args['after'] );
}

function display_categories( array $args = [] ) {

	echo render_categories( $args ); // phpcs:ignore
}

/**
 * Returns the post terms HTML.
 *
 * @since  3.0.0
 * @access public
 * @param  array  $args
 * @return string
 */
function render_categories( array $args = [] ) {

	$html = '';

	$args = wp_parse_args( $args, [
		'taxonomy' => 'category',
		'text'     => '%s',
		'class'    => 'cat-list',
		'sep'      => _x( ' | ', 'taxonomy terms separator', 'backdrop' ),
		'before'   => '<div class="cat-link">',
		'after'    => '</div>'
	] );

	// Append taxonomy to class name.
	if ( ! $args['class'] ) {
		$args['class'] = "entry-terms";
	}

	$cat = get_the_term_list( get_the_ID(), $args['taxonomy'], '', $args['sep'], '' );

	if ( $cat ) {

		$html = sprintf(
			'<i class="fas fa-folder-open"></i> <span class="%s">%s</span>',
			esc_attr( $args['class'] ),
			sprintf( $args['text'], $cat )
		);

		$html = $args['before'] . $html . $args['after'];
	}

	return apply_filters( 'backdrop/theme/display/categories', $html );
}


function display_tags( array $args = [] ) {

	echo render_tags( $args ); // phpcs:ignore
}

/**
 * Returns the post terms HTML.
 *
 * @since  3.0.0
 * @access public
 * @param  array  $args
 * @return string
 */
function render_tags( array $args = [] ) {

	$html = '';

	$args = wp_parse_args( $args, [
		'taxonomy' => 'post_tag',
		'text'     => '%s',
		'class'    => 'tag-list',
		'sep'      => _x( ' | ', 'taxonomy terms separator', 'backdrop' ),
		'before'   => '<div class="tag-link">',
		'after'    => '</div>'
	] );

	// Append taxonomy to class name.
	if ( ! $args['class'] ) {
		$args['class'] = "entry-terms";
	}

	$tags = get_the_term_list( get_the_ID(), $args['taxonomy'], '', $args['sep'], '' );

	if ( $tags ) {

		$html = sprintf(
			'<i class="fas fa-tags"></i> <span class="%s">%s</span>',
			esc_attr( $args['class'] ),
			sprintf( $args['text'], $tags )
		);

		$html = $args['before'] . $html . $args['after'];
	}

	return apply_filters( 'backdrop/theme/display/tags', $html );
}