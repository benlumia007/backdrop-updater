<?php
/**
 * Boot the framework.
 *
 * Container classes should be used for storing, retrieving, and resolving
 * classes/objects passed into them.
 *
 * @package   Backdrop Post Types
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright Copyright (C) 2019-2021. Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Create a new framework instance
 *
 * This will create an instance of the framework allowing you to initialize the theme.
 */
$backdrop_updater = new Benlumia007\Backdrop\Framework();

/**
 * Register default providers
 */
$backdrop_updater->provider( Benlumia007\Backdrop\Updater\Settings\Provider::class );
$backdrop_updater->provider( Benlumia007\Backdrop\Updater\Theme\Type\Provider::class );
$backdrop_updater->provider( Benlumia007\Backdrop\Updater\Theme\Meta\Provider::class );
$backdrop_updater->provider( Benlumia007\Backdrop\Updater\Theme\Manage\Provider::class );
$backdrop_updater->provider( Benlumia007\Backdrop\Updater\Api\Provider::class );

/**
 * Boot the Framework
 */
$backdrop_updater->boot();
