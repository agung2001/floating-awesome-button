<?php

namespace Fab\Controller;

! defined( 'WPINC ' ) or die;

/**
 * Plugin hooks in a backend
 *
 * @package    Fab
 * @subpackage Fab/Controller
 */

use Fab\View;
use Fab\Wordpress\Hook\Action;

class Frontend extends Base {

	/**
	 * Frontend constructor
	 *
	 * @return void
	 * @var    object   $plugin     Plugin configuration
	 * @pattern prototype
	 */
	public function __construct( $plugin ) {
		parent::__construct( $plugin );

		/** @frontend - Add Table Of Content Widget */
		$action = new Action();
		$action->setComponent( $this );
		$action->setHook( 'widgets_init' );
		$action->setCallback( 'fab_register_widget' );
		$action->setMandatory( true );
		$action->setFeature( $plugin->getFeatures()['core_frontend'] );
		$this->hooks[] = $action;

		/** @frontend - Eneque scripts */
		$action = clone $action;
		$action->setComponent( $this );
		$action->setHook( 'wp_enqueue_scripts' );
		$action->setCallback( 'frontend_enequeue' );
		$action->setAcceptedArgs( 1 );
		$action->setPriority( 20 );
		$action->setFeature( $plugin->getFeatures()['core_frontend'] );
		$this->hooks[] = $action;

		/** @frontend - Add float action button asset */
		$action = clone $action;
		$action->setComponent( $this );
		$action->setHook( 'wp_footer' );
		$action->setCallback( 'wp_footer' );
		$action->setFeature( $plugin->getFeatures()['core_frontend'] );
		$this->hooks[] = $action;
	}

	/**
	 * Eneque scripts to @frontend
	 *
	 * @return  void
	 * @var     array   $hook_suffix     The current admin page
	 */
	public function frontend_enequeue( $hook_suffix ) {
		define( 'FAB_SCREEN', json_encode( $this->WP->getScreen() ) );
		$config = $this->WP->get_option( 'fab_config' );

		/** Load Inline Script */
		$this->WP->wp_enqueue_script( 'fab-local', 'local/fab.js', array(), '', true );
		$this->WP->wp_localize_script(
			'fab-local',
			'FAB_PLUGIN',
			array(
				'name'    => FAB_NAME,
				'version' => FAB_VERSION,
				'screen'  => FAB_SCREEN,
				'path'    => FAB_PATH,
				'options' => array(
					'animation' => $config->fab_animation,
				),
			)
		);

		/** Load Vendors */
		if ( isset( $config->fab_animation->enable ) && $config->fab_animation->enable ) {
			$this->WP->wp_enqueue_style( 'animatecss', 'vendor/animatecss/animate.min.css' );
		}
		$this->WP->enqueue_assets( $config->fab_assets->frontend );

		/** Load Plugin Assets */
		$this->WP->wp_enqueue_style( 'fab', 'build/css/frontend.min.css' );
		$this->WP->wp_enqueue_script( 'fab', 'build/js/frontend/plugin.min.js', array(), '', true );
	}

	/**
	 * Display the html element from view Frontend/float_button.php
	 *
	 * @return  void
	 */
	public function wp_footer() {
		global $post;
		$Fab            = $this->Plugin->getModels()['Fab'];
		$fab_to_display = $Fab->get_lists_of_fab( array( 'validateLocation' => true ) )['items'];

		/** Show FAB Button */
		if ( ! is_admin() && $fab_to_display ) {
			$view = new View( $this->Plugin );
			$view->setTemplate( 'frontend.blank' );
			$view->setSections(
				array(
					'Frontend.float_button' => array(
						'name'   => 'Float Button',
						'active' => true,
					),
				)
			);
			$view->setData( compact( 'post', 'fab_to_display' ) );
			$view->setOptions( array( 'shortcode' => false ) );
			$view->build();
		}
	}

	/** Register widgets */
	public function fab_register_widget() {
		/** Grab FAB with widget type */
		$Fab     = $this->Plugin->getModels()['Fab'];
		$widgets = $Fab->get_lists_of_fab(
			array(
				'filterbyType' => array( 'widget', 'widget_content' ),
			)
		)['items'];

		/** Register Sidebar */
		foreach ( $widgets as $widget ) {
			register_sidebar(
				array(
					'name'          => __( $widget->getTitle(), 'fab-widget-' . $widget->getSlug() ),
					'id'            => 'fab-widget-' . $widget->getSlug(),
					'before_widget' => '<div id="%1$s" class="widget fab-container %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h3 class="widgettitle">',
					'after_title'   => '</h3>',
				)
			);
		}
	}

}
