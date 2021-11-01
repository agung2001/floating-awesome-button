<?php

namespace Fab\Model;

!defined( 'WPINC ' ) or die;

/**
* Initiate plugins
*
* @package    Fab
* @subpackage Fab/Model
*/

use Fab\Helper\FABMetaboxLocation;
use Fab\Helper\FABMetaboxSetting;
use Fab\Wordpress\Hook\Action;
use Fab\Helper\FABItem;

class Fab extends Model {
    
    /** global $post */
    protected $post;

    /**
    * constructor
    * @return void
    * @var    object $plugin Plugin configuration
    * @pattern prototype
    */
    public function __construct(\Fab\Plugin $plugin){

        /** Create a post type */
        parent::__construct($plugin);
        $this->args['public'] = true;
        $this->args['publicly_queryable'] = false;
        $this->args['menu_icon'] = json_decode(FAB_PATH)->plugin_url . '/assets/img/icon.png';
        $this->args['has_archive'] = false;

        /** @backend - Save Metabox Setting to postmeta */
        $action = new Action();
        $action->setComponent($this);
        $action->setHook("save_post");
        $action->setCallback('metabox_save_data');
        $action->setMandatory(true);
        $action->setDescription('Save FAB Metabox Data');
        $this->hooks[] = $action;

    }  
    
    /**
    * Save metabox data when post is saving
    * @return void
    */
    public function metabox_save_data()
    {
        global $post;

        /** Check Correct Post Type, Ignore Trash */
        if( !isset($post->ID) || $post->post_type!='fab' || $post->post_status=='trash') return;

        /** Save Metabox Setting */
        $FABMetaboxSetting = new FABMetaboxSetting();
        $FABMetaboxSetting->sanitize();
        $FABMetaboxSetting->setDefaultInput();
        $FABMetaboxSetting->save();

        /** Save Metabox Location */
        $FABMetaboxLocation = new FABMetaboxLocation();
        $FABMetaboxLocation->sanitize();
        $FABMetaboxLocation->transformData();
        $FABMetaboxLocation->save();
    }

    /**
     * Return fabs item and fabs order
     */
    public function get_lists_of_fab($args = []){
        /** Data */
        $order = [];
        $items = [];

        /** Grab Data - Ordered Data */
        $fab_order = $this->WP->get_option('fab_config')->fab_order;
        if($fab_order){
            $order = $fab_order;
            foreach($fab_order as $value)
                $items[] = get_post($value);
        }

        /** Grab Data - Unordered */
        $items = array_merge($items, get_posts([
            'posts_per_page' => -1,
            'post_type' => $this->getName(),
            'post_status' => ['publish'],
            'post__not_in'=> empty($fab_order) ?
                [ 'empty' ] : $fab_order,
            'orderby' => 'post_date',
            'order' => 'DESC',
        ]));

        /** Filter by Location */
        $tmp = [];
        foreach($items as &$item){
            $item = new FABItem($item->ID); // Grab FAB Item
            $order[] = $item->getID();
            if( isset($args['validateLocation']) &&
                !empty($item->getLocations()) &&
                !$item->isToBeDisplayed()
            ) continue; // Check location rules
            $tmp[] = $item; // tmp location
        }
        $items = $tmp;

        /** Filter by Type */
        if( isset($args['filterbyType']) ){
            $tmp = [];
            foreach($items as $item){
                if( in_array($item->getType(),$args['filterbyType']) )
                    $tmp[] = $item;
            }
            $items = $tmp;
        }

        return [
            'order' => $order,
            'items' => $items,
        ];
    }

}

