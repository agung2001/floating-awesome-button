<?php

namespace Fab\Feature;

! defined( 'WPINC ' ) or die;

/**
 * Initiate plugins
 *
 * @package    Fab
 * @subpackage Fab\Includes
 */

class Modal extends Feature {

	/** FAB Modal Theme */
	public static $theme = array(
		array(
			'id'   => 'blank',
			'text' => 'Blank',
		),
		array(
			'id'   => 'window-light',
			'text' => 'Window Light',
		),
		array(
			'id'   => 'window-dark',
			'text' => 'Window Dark',
		),
	);

    /**
     * Feature construect
     *
     * @return void
     * @var    object   $plugin     Feature configuration
     * @pattern prototype
     */
    public function __construct( $plugin ) {
        parent::__construct( $plugin );
        $this->WP          = $plugin->getWP();
        $this->key         = 'core_modal';
        $this->name        = 'Modal';
        $this->description = 'Handles plugin core modal';
    }

}
