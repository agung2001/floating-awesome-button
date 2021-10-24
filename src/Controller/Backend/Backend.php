<?php

namespace Fab\Controller;

!defined( 'WPINC ' ) or die;

/**
 * Plugin hooks in a backend
 *setComponent
 * @package    Fab
 * @subpackage Fab/Controller
 */

use Fab\Wordpress\Hook\Action;

class Backend extends Base {

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
        $action->setCallback('backend_enequeue');
        $action->setAcceptedArgs(1);
        $action->setMandatory(true);
        $action->setDescription('Enqueue backend plugins assets');
        $action->setFeature($plugin->getFeatures()['core_backend']);
        $this->hooks[] = $action;

        
        /** @backend - Add setting link for plugin in plugins page */
        $page = strtolower(FAB_NAME);
        $page = str_replace(' ','-',$page);
        $action = clone $action;
        $action->setHook( sprintf("plugin_action_links_%s/%s.php",$page,$page) );
        $action->setCallback('backend_plugin_setting_link');
        $action->setMandatory(false);
        $action->setDescription('Add setting link for plugin in plugins page');
        $action->setFeature($plugin->getFeatures()['core_backend']);
        $this->hooks[] = $action;
    }

    /**
     * Eneque scripts @backend
     * @return  void
     * @var     array   $hook_suffix     The current admin page
     */
    public function backend_enequeue($hook_suffix){
        define('FAB_SCREEN', json_encode($this->WP->getScreen()));
        $page = strtolower($this->Plugin->getName());
        $page = str_replace(' ','-', $page) . '-setting';
        $screens = ["settings_page_" . $page];
        $this->backend_load_plugin_libraries($screens, ['fab']);
        $this->backend_load_plugin_scripts();
    }

    /**
     * Enqueue backend plugin script
     */
    public function backend_load_plugin_scripts(){
        $screen = json_decode(FAB_SCREEN);
    }

    /**
     * Add setting link in plugin page
     * @backend
     * @return  void
     * @var     array   $links     Plugin links
     */
    public function backend_plugin_setting_link($links){
        $page = strtolower($this->Plugin->getName());
        $page = str_replace(' ','-', $page) . '-setting';
        return array_merge($links, ['<a href="options-general.php?page=' .$page. '">Settings</a>']);
    }

    /**
     * Save given options to database
     * @backend - @pageSetting
     * @return  bool
     */
    public function saveSettings(){
        /** Transform & save field key */
        $options = $this->Plugin->getConfig()->options;
        foreach($_POST as $key => $value){
            /** Transform & save json string */
            if(strpos($key, '_array')) $value = stripslashes($value);
            /** Transform & save default input */
            unset($options->$key);
            $key = str_replace('field_option','fab',$key);
            $key = str_replace('field_array','fab',$key);
            $value = ($value=='true' || $value=='on') ? 'true' : $value;
            $value = ($value=='false') ? '' : $value;
            $value = ( $this->Helper->isJson(str_replace('\"','"', $value)) ) ?
                json_decode(str_replace('\"','"', $value)) : $value;
            $options->$key = $value;
        }
        $this->WP->update_option('fab_config', $options);
        return $options;
    }

}