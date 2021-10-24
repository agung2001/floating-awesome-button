<?php

namespace Fab\Feature;

!defined( 'WPINC ' ) or die;

/**
 * Initiate plugins
 *
 * @package    Fab
 * @subpackage Fab\Includes
 */

class Asset extends Feature {

    /**
     * Feature construect
     * @return void
     * @var    object   $plugin     Feature configuration
     * @pattern prototype
     */
    public function __construct($plugin){
        parent::__construct($plugin);
        $this->key = 'core_asset';
        $this->name = 'Asset';
        $this->description = 'Handles plugin core asset';
        $this->options = [
            'fab_assets',
        ];
    }

}