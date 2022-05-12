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

# Add extra support for post types.
add_action( 'init', __NAMESPACE__ . '\post_type_support' );

# Filters for the archive title and description.
add_filter( 'get_the_archive_title', __NAMESPACE__ . '\archive_title' );

# Default excerpt more.
add_filter( 'excerpt_more', __NAMESPACE__ . '\excerpt_more' );

# Filter the comments template
add_filter( 'comments_template', __NAMESPACE__ . '\comments_template' );