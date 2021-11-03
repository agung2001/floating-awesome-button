<?php

namespace Fab\Feature;

! defined( 'WPINC ' ) or die;

/**
 * Initiate plugins
 *
 * @package    Fab
 * @subpackage Fab\Includes
 */

class Order extends Feature {

	/**
	 * Feature construect
	 *
	 * @return void
	 * @var    object   $plugin     Feature configuration
	 * @pattern prototype
	 */
	public function __construct( $plugin ) {
		parent::__construct( $plugin );
		$this->key         = 'core_order';
		$this->name        = 'Order';
		$this->description = 'Sort FAB Orders';
		$this->options     = array(
			'fab_order',
		);
	}

}
