<?php //phpcs:ignore
/**
 * Backdrop Core ( functions-site.php )
 *
 * @package     Backdrop Core
 * @copyright   Copyright (C) 2019-2020. Benjamin Lu
 * @license     GNU General PUblic License v2 or later ( https://www.gnu.org/licenses/gpl-2.0.html )
 * @author      Benjamin Lu ( https://benjlu.com )
 */

/**
 * Define namespace
 */
namespace Benlumia007\Backdrop\Theme\Menu;

function display( $type, $items = [] ) {
	foreach ( $items as $item ) {
		switch ( $type ) {
			case 'menu':
				menu( $item );
				break;
			default:
				break;
		}
	}
}

function menu( $item ) {
	if ( 'primary' === $item ) {
		if ( has_nav_menu( 'primary' ) ) { ?>
			<nav id="primary" class="primary-menu">
				<button class="menu-toggle" aria-conrol="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'backdrop' ); ?></button>
				<?php
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'container'      => '',
							'menu_id'        => 'primary-menu',
							'menu_class'     => 'menu-items',
							'depth'          => 2
						)
					);
				?>
			</nav>
		<?php }
	} elseif ( 'secondary' === $item ) { ?>
		<nav id="secondary" class="secondary-navigation">
			<?php
				wp_nav_menu(
					array(
						'theme_location' => 'secondary',
						'depth'			 => 1,
					)
				);
			?>
		</nav>
	<?php } elseif ( 'social' === $item ) {
		if ( has_nav_menu( 'social' ) ) { ?>
			<nav id="social" class="site-social">
				<?php
					wp_nav_menu(
						array(
							'theme_location'  => 'social',
							'container'       => 'nav',
							'container_id'    => 'menu-social',
							'container_class' => 'menu-social',
							'menu_id'         => 'menu-social-items',
							'menu_class'      => 'menu-items',
							'depth'           => 1,
							'link_before'     => '<span class="screen-reader-text">',
							'link_after'      => '</span>',
							'fallback_cb'     => '',
						)
					);
				?>
			</nav>
		<?php }
	}
}