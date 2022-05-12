<?php //phpcs:ignore
/**
 * Backdrop Core ( functions-view.php )
 *
 * @package   Backdrop Core
 * @copyright Copyright (C) 2019-2021. Benjamin Lu
 * @author    Benjamin Lu ( https://getbenonit.com )
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Define namespace
 */
namespace Benlumia007\Backdrop\Theme\Sidebar;


function display( $type, $items = [] ) {
	foreach ( $items as $item ) {
		switch ( $type ) {
			case 'sidebar': ?>
				<div id="aside" class="widget-area">
					<?php dynamic_sidebar( $item ); ?>
				</div>
				<?php
				break;
			default:
				break;
		}
	}
}