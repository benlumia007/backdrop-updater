<?php
/**
 * Backdrop Core ( src/Template/Template/Component.php )
 *
 * @package   Backdrop Core
 * @copyright Copyright (C) 2019-2021. Benjamin Lu
 * @author    Benjamin Lu ( https://getbenonit.com )
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Define namespace
 */
namespace Benlumia007\Backdrop\Template\Manager;
use Benlumia007\Backdrop\Contracts\Bootable;

/**
 * Template interface.
 * 
 * @since  3.0.0
 * @access public
 */
class Component implements Bootable {
    	/**
	 * Templates collection.
	 *
	 * @since  3.0.0
	 * @access protected
	 * @var    Templates
	 */
	protected $templates;

	/**
	 * Sets the initial templates collection.
	 *
	 * @since  3.0.0
	 * @access public
	 * @param  Templates  $templates
	 * @return void
	 */
	public function __construct( Templates $templates ) {

		$this->templates = $templates;
	}

	/**
	 * Sets up the templates manager actions and filters.
	 *
	 * @since  3.0.0
	 * @access public
	 * @return void
	 */
	public function boot() {

		// Add registration callback.
		add_action( 'init', [ $this, 'register' ], 95 );

		// Filter theme post templates to add registered templates.
		add_filter( 'theme_templates', [ $this, 'postTemplates' ], 5, 4 );
	}

	/**
	 * Executes the action hook for themes to register their templates.
	 * Themes should always register on this hook.
	 *
	 * Note that this method is `public` because of WP's hook callback
	 * system. See the implemented contract for publicly-available methods.
	 *
	 * @since  3.0.0
	 * @access public
	 * @return void
	 */
	public function register() {

		do_action( 'backdrop/templates/register', $this->templates );
	}

	/**
	 * Filter used on `theme_templates` to add custom templates to the template
	 * drop-down.
	 *
	 * Note that this method is `public` because of WP's hook callback
	 * system. See the implemented contract for publicly-available methods.
	 *
	 * @since  3.0.0
	 * @access public
	 * @param  array   $templates
	 * @param  object  $theme
	 * @param  object  $post
	 * @param  string  $post_type
	 * @return array
	 */
	public function postTemplates( $templates, $theme, $post, $post_type ) {

		foreach ( $this->templates->all() as $template ) {

			if ( $template->forPostType( $post_type ) ) {

				$templates[ $template->filename() ] = esc_html( $template->label() );
			}
		}

		return $templates;
	}
}