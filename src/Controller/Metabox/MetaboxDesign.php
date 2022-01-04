<?php

namespace Fab\Controller;

! defined( 'WPINC ' ) or die;

/**
 * Initiate plugins
 *
 * @package    Fab
 * @subpackage Fab/Controller
 */

use Fab\View;
use Fab\Helper\FABItem;
use Fab\Feature\Design;
use Fab\Feature\Modal;
use Fab\Wordpress\Hook\Action;
use Fab\Wordpress\MetaBox;

class MetaboxDesign extends Base {

    /**
     * Admin constructor
     *
     * @return void
     * @var    object   $plugin     Plugin configuration
     * @pattern prototype
     */
    public function __construct( $plugin ) {
        parent::__construct( $plugin );

        /** @backend - Eneque scripts */
        $action = new Action();
        $action->setComponent( $this );
        $action->setHook( 'admin_enqueue_scripts' );
        $action->setCallback( 'backend_enequeue_metabox_design' );
        $action->setAcceptedArgs( 1 );
        $action->setMandatory( true );
        $action->setDescription( 'Enqueue backend metabox design' );
        $action->setFeature( $plugin->getFeatures()['core_backend'] );
        $this->hooks[] = $action;

        /** @backend - Add Designs metabox to Fab CPT */
        $action = new Action();
        $action->setComponent( $this );
        $action->setHook( 'add_meta_boxes' );
        $action->setCallback( 'metabox_design' );
        $action->setMandatory( false );
        $action->setDescription( 'Add Design metabox to Fab CPT' );
        $action->setFeature( $plugin->getFeatures()['core_backend'] );
        $action->setPremium( false );
        $this->hooks[] = $action;
    }

    /**
     * Eneque scripts @backend
     *
     * @return  void
     * @var     array   $hook_suffix     The current admin page
     */
    public function backend_enequeue_metabox_design( $hook_suffix ) {
        /** Grab Data */
        global $post;
        if ( ! isset( $post->post_type ) || $post->post_type != 'fab' ) {
            return;
        }

        /** Add Inline Script */
        $this->WP->wp_localize_script( 'fab-local', 'FAB_METABOX_DESIGN', array(
            'defaultOptions' => [
                'size' => array( 'type' => Design::$size['type'] ),
                'theme' => Modal::$theme,
                'template' => Design::$template,
            ],
        ));

        /** Enqueue */
        $this->WP->wp_enqueue_script( 'fab-design', 'build/js/backend/metabox-design.min.js', array(), '', true );
    }

    /**
     * Register metabox designs on custom post type Fab
     *
     * @return      void
     */
    public function metabox_design() {
        $metabox = new MetaBox();
        $metabox->setScreen( 'fab' );
        $metabox->setId( 'fab-metabox-design' );
        $metabox->setTitle( 'Design' );
        $metabox->setCallback( array( $this, 'metabox_design_callback' ) );
        $metabox->setCallbackArgs( array( 'is_display' => false ) );
        $metabox->build();
    }


    /**
     * Metabox Design set view template
     *
     * @return      string              Html template string from view View/Template/backend/metabox_design.php
     * @param       object $post      global $post object
     */
    public function metabox_design_callback() {
        global $post;

        $default = $this->Plugin->getConfig()->default;
        $config  = $this->Plugin->getConfig()->options;

        /** Set View */
        $view = new View( $this->Plugin );
        $view->setTemplate( 'backend.blank' );
        $view->setSections(
            array(
                'Backend.Metabox.design' => array(
                    'name'   => '',
                    'active' => true,
                ),
            )
        );
        $view->setData(
            array(
                'fab' => new FABItem( $post->ID ),
                'options' => (object) ( (array) $config + (array) $default ),
            )
        );
        $view->build();
    }

}