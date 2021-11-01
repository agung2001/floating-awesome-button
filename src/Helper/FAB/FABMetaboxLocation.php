<?php

namespace Fab\Helper;

!defined( 'WPINC ' ) or die;

/**
 * Plugin hooks in a backend
 * @package    Fab
 * @subpackage Fab/Controller
 */

use Fab\Wordpress\Model\Metabox;

class FABMetaboxLocation extends Metabox {

    /** FAB Metabox Operator */
    public static $operator = [
        ['id' => '==', 'text' => 'is equal to'],
        ['id' => '!=', 'text' => 'is not equal to'],
    ];

    /** $_POST input */
    public static $input = [
        'fab_location_type' => [ 'type' => 'text', 'default' => '' ,'sub_meta_key' => 'type'],
        'fab_location_operator' => [ 'type' => 'text', 'default' => '' ,'sub_meta_key' => 'operator'],
        'fab_location_value' => [ 'type' => 'text', 'default' => '' ,'sub_meta_key' => 'value'],
    ];

    /** FAB Metabox Post Metas */
    public static $post_metas = [
        'locations' => [ 'meta_key' => 'fab_location'],
    ];

    /** Constructor */
    public function __construct(){
        $plugin = \Fab\Plugin::getInstance();
        $this->WP = $plugin->getWP();
    }

    /** Sanitize */
    public function sanitize(){
        /** $_POST Data for metabox location */
        $params = self::$input;

        /** Check Data Type is Correct Before Continue */
        foreach($params as $key => $meta){ if(!isset($_POST[$key]) || !is_array($_POST[$key])) return; }

        /** Sanitize Params */
        $rulesCount = 0;
        foreach($params as $key => &$meta){
            $type = $meta['type']; $meta = [];
            foreach($_POST[$key] as $value){
                $meta[] = $this->WP->sanitize($type, $value);
                $rulesCount++;
            }
        }

        /** Save as Params */
        $this->params = $params;
    }

    /** transformData */
    public function transformData(){
        /** Transform Locations */
        $locations = [];
        foreach(self::$input as $key => $meta){
            foreach($this->params[$key] as $index => $value){
                $locations[$index][$meta['sub_meta_key']] = $value;
            }
        }

        /** Merge duplicate rules */
        $duplicate = [];
        foreach($locations as $location){
            $duplicate[implode('',$location)] = $location;
        }
        $locations = array_values($duplicate);

        /** Prepare parmaeters */
        $this->params = [];
        $this->params[self::$post_metas['locations']['meta_key']] = json_encode($locations);
    }

    /** Save data to database */
    public function save(){
        global $post;
        foreach($this->params as $key => $value){
            if($value) $this->WP->update_post_meta($post->ID, $key, $value);
        }
    }

}