<?php

namespace Fab\Controller;

!defined( 'WPINC ' ) or die;

/**
* Initiate plugins
*
* @package    Fab
* @subpackage Fab/Controller
*/

use Fab\View;
use Fab\Wordpress\Hook\Action;
use Fab\Wordpress\MetaBox;


class BackendMetabox extends Base {
    /**
    * Admin constructor
    * @return void
    * @var    object   $plugin     Plugin configuration
    * @pattern prototype
    */
    public function __construct($plugin){
        parent::__construct($plugin);


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

        /** @backend - Add Settings metabox to Fab CPT */
        $action = clone $action;
        $action->setComponent($this);
        $action->setHook("add_meta_boxes");
        $action->setCallback('metabox_settings');
        $action->setMandatory(false);
        $action->setDescription('Add Setting metabox to Fab CPT');
        $action->setFeature($plugin->getFeatures()['core_backend']);
        $action->setPremium(false);
        $this->hooks[] = $action;
        
        
        /** @backend - Add Json Data that needed on metabox location */
        $action = clone $action;
        $action->setComponent($this);
        $action->setHook("admin_footer");
        $action->setCallback('admin_footer_json_data');
        $action->setMandatory(false);
        $action->setDescription('Add Footer Data for Location');
        $this->hooks[] = $action;
    }


    /**
     * Set view template for Add Json Data that needed on metabox location
     * @return      void                Html template string from view View/Template/backend/metabox_location_json.php
     */
    public function admin_footer_json_data()
    {
        /** Set View */
        global $post;
        if( empty($post->ID) || $post->post_type!='fab' ) return;
        $view = new View($this->Plugin);
        $view->setTemplate('backend.blank');
        $view->setSections(['Backend.Metabox.metabox_location_json'=>['name'=>'','active'=>true]]);
        $view->setData($this->metabox_location_data($post->ID));
        $view->build();
    }
    
    /**
     * Register metabox settings on custom post type Fab
     * @return      void
     */
    public function metabox_settings()
    {
        $metabox = new MetaBox;
        $metabox->setScreen('fab');
        $metabox->setId('fab-metabox-settings');
        $metabox->setTitle('Setting');
        $metabox->setCallback([$this,'metabox_settings_callback']);
        $metabox->setCallbackArgs(['is_display'=>false]);
        $metabox->build();
    }
    
    
    /**
     * Metabox Setting set view template
     * @return      string              Html template string from view View/Template/backend/metabox_settings.php
     * @param       object   $post      global $post object
     */
    public function metabox_settings_callback($post)
    {
        /** Set View */
        $view = new View($this->Plugin);
        $view->setTemplate('backend.blank');
        $view->setSections(['Backend.Metabox.metabox_settings'=>['name'=>'','active'=>true]]);
        $view->setData($this->metabox_setting_data($post->ID));
        $view->build();
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
     * @param       object   $post      global $post object
     */
    public function metabox_location_callback($post)
    {
        /** Set View */
        $view = new View($this->Plugin);
        $view->setTemplate('backend.blank');
        $view->setSections(['Backend.Metabox.metabox_location'=>['name'=>'','active'=>true]]);
        $view->setData($this->metabox_location_data($post->ID));
        $view->build();
    }


    
    /**
     * Load metabox data needed on metabox setting
     * @return      array               All that saved or default configuration
     *          [
     *              'fab_setting_enable'=> boolean,
     *              'fab_setting_icon_class'=> string 'fas fa-bookmark',
     *              'fab_setting_type'=> string 'widget' or 'link',
     *          ]
     * @param       int   $post_id      current edited Custom post type Fab
     */
    public function metabox_setting_data($post_id)
    {
        $Fab = $this->Plugin->getModels()['Fab'];
        
        return [
            'fab_setting_enable'=>$Fab->isEnabled($post_id),
            'fab_setting_icon_class'=>$Fab->getIconClass($post_id),
            'fab_setting_type'=>$Fab->getFabType($post_id),
            'fab_setting_open_in'=>$Fab->getLinkBehaviour($post_id),
            'fab_setting_link'=>$Fab->getLink($post_id),
            'fab_setting_key'=>$Fab->getHotKey($post_id),
        ];
    }


    /**
     * Load metabox data needed on metabox location
     * @return      array               All that saved or default configuration
     *          [
     *              'when_data'=> array
     *              'fab_location'=> default [{'type':'post','operator'=>'==',value:'post'},{...}]; 
     *          ]
     * @param       int   $post_id      current edited Custom post type Fab
     */
    
    public function metabox_location_data($post_id)
    {
        $all_post_types = get_post_types(['public' => true],'object');
        $post_types =[];
        foreach($all_post_types as $post_type_obj){
            $key = esc_attr( $post_type_obj->name );
            $labels = get_post_type_labels( $post_type_obj );
            $post_types[$key] = $labels->name;
        }
        
        $all_pages = get_pages(); 
        $pages = [];
        foreach($all_pages as $page){
            $pages[$page->ID] = get_the_title( $page->ID );
        }
        $whenData = [
            [
                'id'=>'post_type',
                'label'=>'Post Type',
                'compares'=>$post_types,
            ],
            [
                'id'=>'page',
                'label'=>'Page',
                'compares'=>$pages,
            ],
            
        ];
        
        $Fab = $this->Plugin->getModels()['Fab'];
        
        $fab_location =$Fab->get_location($post_id);
        $fab_location = $fab_location ? $fab_location : [['type'=>'-','operator'=>'==','value'=>'-']];
        foreach($fab_location as $key=>$fl){
            $compares = [];
            foreach($whenData as $w_data){
                if($w_data['id']==$fl['type']){
                    $compares = $w_data['compares'];
                    break;
                }
            }
            
            $fab_location[$key]['compares']=$compares;
        }
        return [
            'when_data'=>$whenData,
            'fab_location'=>$fab_location,
        ];
    }
}