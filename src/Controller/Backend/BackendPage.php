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
use Fab\Wordpress\Page\SubmenuPage;

class BackendPage extends Base {
    
    /**
    * Admin constructor
    * @return void
    * @var    object   $plugin     Plugin configuration
    * @pattern prototype
    */
    public function __construct($plugin){
        parent::__construct($plugin);
        
        /** @backend - Add custom admin page under settings */
        $action = new Action();
        $action->setComponent($this);
        $action->setHook('admin_menu');
        $action->setCallback('page_setting');
        $action->setMandatory(true);
        $action->setFeature($plugin->getFeatures()['core_backend']);
        $this->hooks[] = $action;
        
        
    }
    
    
    /**
    * Page Setting
    * @backend @submenu setting
    * @return  void
    */
    public function page_setting(){
        /** Plugin slug */
        $slug = strtolower($this->Plugin->getName());
        $slug = str_replace(' ','-', $slug) . '-setting';

        /** Handle submission config */
        if(isset($_GET['page']) && $_GET['page']==$slug){
            if($_POST && isset($_POST['clear-config'])){ /** Clear Config */
                $this->WP->delete_option('fab_config');
                $this->WP->update_option('fab_config', $this->Plugin->getConfig()->default);
            } elseif($_POST) { /** Save Config */
                $this->loadController('Backend');
                $result = $this->Backend->saveSettings();
                $result = ($result) ? 'true' : 'false';
            }
        }
        
        /** Transform features */
        $features = $this->Plugin->getFeatures();
        $featureHooks = [];
        /** Map Controller */
        foreach($this->Plugin->getControllers() as $name => $controller){
            foreach($controller->getHooks() as $hook){
                $feature = ($hook->getFeature()) ? $hook->getFeature()->getKey() : 'others';
                $featureHooks[$feature][] = $hook;
            }
        }
        /** Map APIs */
        $APIs = $this->Plugin->getApis();
        if($APIs) {
            foreach ($APIs as $name => $controller) {
                foreach ($controller->getHooks() as $hook) {
                    $feature = ($hook->getFeature()) ? $hook->getFeature()->getKey() : 'others';
                    $featureHooks[$feature][] = $hook;
                }
            }
        }
        
        /** Section */
        $sections = [];
        $sections['Backend.setting'] = ['name' => 'Setting', 'active' => true];
        if(!$this->Plugin->getConfig()->production)
        $sections['Backend.feature'] = ['name' => 'Feature'];
        $sections['Backend.about'] = ['name' => 'About'];
        
        /** Set View */
        $view = new View($this->Plugin);
        $view->setTemplate('backend.default');
        $view->setSections($sections);
        $view->addData([
            'result'        => isset($result) ? $result : '',
            'background'    => 'bg-alizarin',
            'features'      => $features,
            'featureHooks'  => $featureHooks,
            'options'       => $this->WP->get_option('fab_config')
        ]);
        $view->setOptions(['shortcode' => false]);
        
        /** Set Page */
        $page = new SubmenuPage();
        $page->setParentSlug('options-general.php');
        $page->setPageTitle(FAB_NAME);
        $page->setMenuTitle(FAB_NAME);
        $page->setCapability('manage_options');
        $page->setMenuSlug($slug);
        $page->setFunction([$page, 'loadView']);
        $page->setView($view);
        $page->build();
    }
    
}