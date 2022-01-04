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
use Fab\Wordpress\Hook\Filter;
use Fab\Metabox\FABMetaboxSetting;

class Frontend extends Base {

    /** FAB To Display Args */
    protected $fab_to_display_args = array(
        'validateLocation' => true,
    );

	/**
	 * Frontend constructor
	 *
	 * @return void
	 * @var    object   $plugin     Plugin configuration
	 * @pattern prototype
	 */
	public function __construct( $plugin ) {
		parent::__construct( $plugin );

		/** @frontend */
		$action = new Action();
		$action->setComponent( $this );
		$action->setHook( 'widgets_init' );
		$action->setCallback( 'fab_register_widget' );
		$action->setMandatory( true );
		$action->setDescription( 'Add Table Of Content Widget' );
		$action->setFeature( $plugin->getFeatures()['core_frontend'] );
		$this->hooks[] = $action;

		/** @frontend */
		$action = clone $action;
		$action->setHook( 'wp_enqueue_scripts' );
		$action->setCallback( 'frontend_enequeue' );
		$action->setAcceptedArgs( 1 );
		$action->setPriority( 20 );
		$action->setDescription( 'Eneque scripts' );
		$action->setFeature( $plugin->getFeatures()['core_frontend'] );
		$this->hooks[] = $action;

		/** @frontend */
		$action = clone $action;
		$action->setHook( 'wp_footer' );
		$action->setCallback( 'fab_loader' );
		$action->setDescription( 'Display the html element from view Frontend/float_button.php' );
		$action->setFeature( $plugin->getFeatures()['core_frontend'] );
		$this->hooks[] = $action;

		/** @frontend */
		$filter = new Filter();
		$filter->setComponent( $this );
		$filter->setHook( 'wp_kses_allowed_html' );
		$filter->setCallback( 'filter_wpkses_posts' );
		$filter->setMandatory( false );
		$filter->setAcceptedArgs( 2 );
		$filter->setDescription( 'Filter wpkses post' );
		$filter->setFeature( $plugin->getFeatures()['core_frontend'] );
		$this->hooks[] = $filter;
	}

	/**
	 * Eneque scripts to @frontend
	 *
	 * @return  void
	 * @var     array   $hook_suffix     The current admin page
	 */
	public function frontend_enequeue( $hook_suffix ) {
		define( 'FAB_SCREEN', json_encode( $this->WP->getScreen() ) );
		$default = $this->Plugin->getConfig()->default;
		$config  = $this->Plugin->getConfig()->options;
        $fab_to_display = $this->Plugin->getModels()['Fab'];
        $fab_to_display = $fab_to_display->get_lists_of_fab( $this->fab_to_display_args )['items'];
        foreach($fab_to_display as &$fab){ $fab = $fab->getVars(); }

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
				'premium' => $this->Helper->isPremiumPlan(),
				'options' => (object) ( (array) $config + (array) $default ),
				'default' => $default,
                'to_display' => $fab_to_display,
			)
		);

		/** Load WP Core jQuery */
		wp_enqueue_script( 'jquery' );

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
	public function fab_loader() {
		global $post;

		/** Ignore in Pages */
		if ( is_single() && isset( $post->post_type ) && $post->post_type === 'fab' ) {
			return;
		}

		/** Grab Data */
		$options        = $this->Plugin->getConfig()->options;
        $Fab = $this->Plugin->getModels()['Fab'];
        $args = $this->fab_to_display_args;
		$fab_to_display = $Fab->get_lists_of_fab( $args )['items'];

		if ( ! is_admin() && $fab_to_display ) {
			/** Show FAB Button */
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
			$view->setData( compact( 'post', 'fab_to_display', 'options' ) );
			$view->setOptions( array( 'shortcode' => false ) );
			$view->build();

			/** Show Modal - Only Default */
			$args['builder'] = array( 'default' );
			$fab_to_display  = $Fab->get_lists_of_fab( $args )['items'];
			$view            = clone $view;
			$view->setSections(
				array(
					'Frontend.modal' => array(
						'name'   => 'Modal',
						'active' => true,
					),
				)
			);
			$view->setData( compact( 'post', 'fab_to_display' ) );
			$view->build();
		}
	}

	/** Register widgets */
	public function fab_register_widget() {
		/** Grab Widgets Type */
		$types       = FABMetaboxSetting::$types;
		$widgetsType = array();
		foreach ( $types as $type ) {
			if ( $type['text'] === 'Widget' ) {
				foreach ( $type['children'] as $child ) {
					$widgetsType[] = $child['id'];
				}
			}
		}

		/** Grab FAB with widget type */
		$Fab     = $this->Plugin->getModels()['Fab'];
		$widgets = $Fab->get_lists_of_fab(
			array(
				'filterbyType' => $widgetsType,
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

	/**
	 * Filter wpkses posts accept iframe, used to embed iframe (youtube, vimeo, etc) with FAB Content
	 */
	public function filter_wpkses_posts( $tags, $context ) {
		$tags['iframe'] = array(
			'src'             => true,
			'height'          => true,
			'width'           => true,
			'frameborder'     => true,
			'allowfullscreen' => true,
		);
		return $tags;
	}

}
