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

class Base extends Controller {

    /**
     * @backend - Load plugin libraries
     * @return  void
     * @var     array   $screens     Lists of screen where the library are loaded
     * @var     array   $types       Lists of post_type where the library are loaded
     * @var     array   $assets      Custom assets for specific page
     */
    protected function backend_load_plugin_libraries($screens = [], $types = [], $assets = []){
        $screen = json_decode(FAB_SCREEN);
        if(in_array($screen->base,$screens) || (isset($screen->post->post_type) && in_array($screen->post->post_type,$types)) ){
            $assets = ($assets) ? array_flip($assets) : $assets;
            $config = $this->WP->get_option('fab_config');
            /** Plugin configuration */
            if(!isset($assets['disableCore'])){
                $view = new View($this->Plugin);
                $view->setTemplate('backend.blank');
                $view->setSections(['Backend.script' => []]);
                $view->setOptions(['shortcode' => false]);
                $view->addData([
                    'path' => json_decode(FAB_PATH),
                    'screen' => json_decode(FAB_SCREEN),
                    'options' => $config
                ]);
                $view->build();
            }
            /** Animate.css */
            if(isset($config->fab_animation) && $config->fab_animation) $this->WP->wp_enqueue_style('animatecss', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css');
            /** Load Assets */
            $this->enqueue_assets($config->fab_assets->backend);
            /** Styles and Scripts */
            $this->WP->wp_enqueue_style('fab_css', "backend.min.css" );
            $this->WP->wp_enqueue_script('fab_js', "backend.min.js",'', '', true);
        }
    }

    /**
     * @frontend - Load plugin libraries
     * @return  void
     * @param     array   $screens     Lists of screen where the library are loaded
     * @param     array   $types       Lists of post_type where the library are loaded
     * @param     array   $assets      Custom assets for specific page
     */
    protected function frontend_load_plugin_libraries($screens = [], $types = [], $assets = []){
        $screen = json_decode(FAB_SCREEN);
        $screen->base = (isset($post->ID) && $this->WP->is_page($post->ID)) ? 'page' : 'archive';
        if(in_array($screen->base,$screens) || (isset($screen->post->post_type) && in_array($screen->post->post_type,$types)) ) {
            $assets = ($assets) ? array_flip($assets) : $assets;
            $config = $this->WP->get_option('fab_config');
            /** Plugin configuration */
            if (!isset($assets['disableCore'])) {
                $view = new View($this->Plugin);
                $view->setTemplate('backend.blank');
                $view->setSections(['Backend.script' => []]);
                $view->setOptions(['shortcode' => false]);
                $view->addData([
                    'path' => json_decode(FAB_PATH),
                    'screen' => json_decode(FAB_SCREEN),
                    'options' => $config
                ]);
                $view->build();
            }
            /** Animate.css */
            if(isset($config->fab_animation) && $config->fab_animation) $this->WP->wp_enqueue_style('animatecss', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css');
            /** Load Assets */
            $this->enqueue_assets($config->fab_assets->frontend);
            /** Styles and Scripts */
            $this->WP->wp_enqueue_style('fab_css', "frontend.min.css");
            $this->WP->wp_enqueue_script('fab_page_js', "frontend.min.js", [], '', true);
        }
    }

    /** Enqueue Assets */
    private function enqueue_assets($assets){
        foreach($assets as $asset_id => $asset){
//            if($asset_id=='select2-css' || $asset_id=='select2-js')continue;

            $asset = (object) $asset;
            if( $asset->type=='css' && $asset->status ) {
                $this->WP->wp_enqueue_style($asset_id, $asset->src);
            } elseif( $asset->type=='js' && $asset->status ) {
                $this->WP->wp_enqueue_script($asset_id, $asset->src, array(), '', isset($asset->in_footer) ? true : false );
            }
        }
    }

}