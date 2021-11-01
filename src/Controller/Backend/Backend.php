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
        $action = clone $action;
        $action->setHook( sprintf("plugin_action_links_%s/%s.php", $this->Plugin->getSlug(), $this->Plugin->getSlug()) );
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
    public function backend_enequeue($hook_suffix)
    {
        define('FAB_SCREEN', json_encode($this->WP->getScreen()));
        $config = $this->WP->get_option('fab_config');
        $screen = $this->WP->getScreen();
        $slug = sprintf('%s-setting',$this->Plugin->getSlug());
        $screens = [sprintf("settings_page_%s", $slug)];
        $types = ['fab'];

        /** Load Inline Script */
        $this->WP->wp_enqueue_script('fab-local', "local/fab.js", [], '', true);
        $this->WP->wp_localize_script( 'fab-local', 'FAB_PLUGIN', array(
            'name' => FAB_NAME,
            'version' => FAB_VERSION,
            'screen' => FAB_SCREEN,
            'path' => FAB_PATH,
            'options' => [
                'animation' => $config->fab_animation,
            ],
        ) );

        /** Load Vendors */
        if(isset($config->fab_animation->enable) && $config->fab_animation->enable)
            $this->WP->wp_enqueue_style('animatecss', "vendor/animatecss/animate.min.css");
        if(in_array($screen->base,$screens) || (isset($screen->post->post_type) && in_array($screen->post->post_type,$types)) ){
            $this->WP->enqueue_assets($config->fab_assets->backend);
        }

        /** Load Plugin Assets */
        $this->WP->wp_enqueue_style('fab', "build/css/backend.min.css");
        $this->WP->wp_enqueue_script('fab', "build/js/backend/plugin.min.js", [], '', true);
    }

    /**
     * Add setting link in plugin page
     * @backend
     * @return  void
     * @var     array   $links     Plugin links
     */
    public function backend_plugin_setting_link($links){
        $slug = sprintf('%s-setting',$this->Plugin->getSlug());
        return array_merge($links, ['<a href="options-general.php?page=' .$slug. '">Settings</a>']);
    }

    /**
     * Save given options to database
     * @backend - @pageSetting
     * @return  bool
     */
    public function saveSettings(){
        /** Sanitize Params */
        $params = [];
        foreach($_POST as $key => $value){
            $params[$key] = $this->WP->sanitize('text', $value);
        }

        /** Transform & save field key */
        $options = $this->Plugin->getConfig()->options;
        foreach($params as $key => $value){
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