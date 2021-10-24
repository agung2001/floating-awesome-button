<?php

namespace Fab\Controller;

!defined( 'WPINC ' ) or die;

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
     * @return void
     * @var    object   $plugin     Plugin configuration
     * @pattern prototype
     */
    public function __construct($plugin){
        parent::__construct($plugin);

        /** @frontend - Add Table Of Content Widget */
        $action = new Action();
        $action->setComponent($this);
        $action->setHook('widgets_init');
        $action->setCallback('fab_register_widget');
        $action->setMandatory(true);
        $action->setFeature($plugin->getFeatures()['core_frontend']);
        $this->hooks[] = $action;

        /** @frontend - Eneque scripts */
        $action = clone $action;
        $action->setComponent($this);
        $action->setHook('wp_enqueue_scripts');
        $action->setCallback('frontend_enequeue');
        $action->setAcceptedArgs(1);
        $action->setFeature($plugin->getFeatures()['core_frontend']);
        $this->hooks[] = $action;

        /** @frontend - Add float action button asset */
        $action = clone $action;
        $action->setComponent($this);
        $action->setHook('wp_footer');
        $action->setCallback('wp_footer');
        $action->setFeature($plugin->getFeatures()['core_frontend']);
        $this->hooks[] = $action;
    }

    /**
     * Eneque scripts to @frontend
     * @return  void
     * @var     array   $hook_suffix     The current admin page
     */
    public function frontend_enequeue($hook_suffix){
        define('FAB_SCREEN', json_encode($this->WP->getScreen()));
        $this->frontend_load_plugin_libraries(['page'], ['docs', 'post','page']);
    }

    /**
     * Display the html element from view Frontend/float_button.php
     * @return  void
     */
    public function wp_footer(){
        global $post;
        
        $Fab = $this->Plugin->getModels()['Fab'];
        $fab_to_display = $Fab->get_fab_to_display($post);
        
        $view = new View($this->Plugin);
        $view->setTemplate('frontend.blank');
        $view->setSections([ 'Frontend.float_button' => ['name' => 'Float Button','active' => true] ]);
        $view->setData(compact('post','fab_to_display'));
        $view->setOptions(['shortcode' => false]);
        $view->build();
        
    }

    /** Register widgets */
    public function fab_register_widget()
    {
        $Fab = $this->Plugin->getModels()['Fab'];
        $widgets = $Fab->get_fab_widget();
        
        foreach($widgets as $widget){
            register_sidebar( array(
                'name' => __( $widget['name'], 'fab-widget-'.$widget['id'] ),
                'id' => 'fab-widget-'.$widget['slug'],
                'before_widget' => '<div id="%1$s" class="widget fab-container %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widgettitle">',
                'after_title' => '</h3>'
            ));
        }
    }

}