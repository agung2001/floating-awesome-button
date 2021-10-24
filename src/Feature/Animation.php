<?php

namespace Fab\Feature;

!defined( 'WPINC ' ) or die;

/**
 * Initiate plugins
 *
 * @package    Fab
 * @subpackage Fab\Includes
 */

class Animation extends Feature {

    /**
     * Feature construect
     * @return void
     * @var    object   $plugin     Feature configuration
     * @pattern prototype
     */
    public function __construct($plugin){
        parent::__construct($plugin);
        $this->key = 'core_animation';
        $this->name = 'Animation';
        $this->description = 'Handles plugin core animation';
        $this->options = [
            'fab_animation',
            'fab_animation_tab',
            'fab_animation_content',
            'fab_animation_active',
            'fab_animation_inactive',
        ];
    }

}