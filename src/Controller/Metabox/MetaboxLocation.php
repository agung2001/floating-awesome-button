<?php

namespace Fab\Controller;

!defined( 'WPINC ' ) or die;

/**
 * Initiate plugins
 *
 * @package    Fab
 * @subpackage Fab/Controller
 */

use Fab\Helper\FABMetaboxLocation;
use Fab\View;
use Fab\Helper\FABItem;
use Fab\Wordpress\Hook\Action;
use Fab\Wordpress\MetaBox;

class MetaboxLocation extends Base {

    /**
     * Admin constructor
     * @return void
     * @var    object   $plugin     Plugin configuration
     * @pattern prototype
     */
    public function __construct($plugin){
        parent::__construct($plugin);

        /** @backend - Eneque scripts */
        $action = new Action();
        $action->setComponent($this);
        $action->setHook('admin_enqueue_scripts');
        $action->setCallback('backend_enequeue_metabox_location');
        $action->setAcceptedArgs(1);
        $action->setMandatory(true);
        $action->setDescription('Enqueue backend metabox location');
        $action->setFeature($plugin->getFeatures()['core_backend']);
        $action->setPremium(true);
        $this->hooks[] = $action;

        /** @backend - Add Location metabox to Fab CPT */
        $action = new Action();
        $action->setComponent($this);
        $action->setHook("add_meta_boxes");
        $action->setCallback('metabox_location');
        $action->setMandatory(false);
        $action->setDescription('Add Location metabox to Fab CPT');
        $action->setPremium(true);
        $action->setFeature($plugin->getFeatures()['core_backend']);
        $this->hooks[] = $action;
    }

    /**
     * Eneque scripts @backend
     * @return  void
     * @var     array   $hook_suffix     The current admin page
     */
    public function backend_enequeue_metabox_location($hook_suffix)
    {
        /** Grab Data */
        global $post;
        if(!isset($post->post_type) || $post->post_type!='fab') return;

        /** Grab Locations */
        $fab = new FABItem($post->ID);
        $locations = $fab->getLocations();
        foreach($locations as &$location){
            if($location['type']!='post_type'){
                $location['value'] = get_post($location['value']);
            }
        }

        /** Add Inline Script */
        $this->WP->wp_localize_script( 'fab-local', 'FAB_METABOX_LOCATION', array(
            'rest_url' => esc_url_raw( rest_url() ),
            'post_types' => get_post_types([
                'public' => true,
                'show_in_rest' => true,
            ], 'objects'),
            'excludes_post_types' => ['attachment'],
            'data' => compact('locations'),
            'defaultOptions' => [ 'operator' => FABMetaboxLocation::$operator ],
        ));

        /** Enqueue */
        $this->WP->wp_enqueue_script('fab-location', "build/js/backend/metabox-location.min.js", [], '', true);
    }

    /**
     * Register metabox location on custom post type Fab
     * @return      void
     */
    public function metabox_location()
    {
        $metabox = new MetaBox;
        $metabox->setScreen('fab');
        $metabox->setId('fab-metabox-location');
        $metabox->setTitle('Location');
        $metabox->setCallback([$this,'metabox_location_callback']);
        $metabox->setCallbackArgs(['is_display'=>false]);
        $metabox->build();
    }

    /**
     * Metabox Location set view template
     * @return      string              Html template string from view View/Template/backend/metabox_location.php
     */
    public function metabox_location_callback()
    {
        /** Set View */
        $view = new View($this->Plugin);
        $view->setTemplate('backend.blank');
        $view->setSections(['Backend.Metabox.metabox_location'=>['name'=>'','active'=>true]]);
        $view->build();
    }

}