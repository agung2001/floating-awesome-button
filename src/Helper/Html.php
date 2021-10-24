<?php

namespace Fab\Helper;

!defined( 'WPINC ' ) or die;

/**
 * Helper library for Fab plugins
 *
 * @package    Fab
 * @subpackage Fab\Includes
 */

trait Html {

    /**
     * Outputing assets
     * @var   string    $src        Full URL of the script, or path of the script relative to the WordPress root directory
     * @var   bool     $asny        Async
     */
    public function css($src){
        $path = json_decode(FAB_PATH)['plugin_url'] . 'assets/css/';
        if(!strpos($src, '//')) $src = $path . $src;
        echo "<link rel='stylesheet' type='text/css' href='$src' />\n";
    }

    /**
     * Outputing assets
     * @var   string    $src        Full URL of the script, or path of the script relative to the WordPress root directory
     * @var   bool     $asny        Async
     */
    public function script($src, $async = false){
        $path = json_decode(FAB_PATH)['plugin_url'] . 'assets/js/';
        if(!strpos($src, '//')) $src = $path . $src;
        $async = ($async) ? 'async' : '';
        echo "<script src='$src' $async></script>\n";
    }

}