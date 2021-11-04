<?php

namespace Fab\Wordpress\Helper;

! defined( 'WPINC ' ) or die;

/**
 * Add extra layer for WordPress functions
 *
 * @package    Fab
 * @subpackage Fab\Wordpress
 */

trait Validate {

	/**
	 * Validate $_POST Params
	 *
	 * @var     array   $_POST      $_POST parameters
	 * @var     array   $default    Default value config
	 * @return  bool    Validation result
	 */
	public function validateParams( $params, $default, $validated = true ) {
		foreach ( $default as $index => $key ) {
			if ( ! isset( $params[ $key ] ) && ! is_array( $key ) ) {
				$validated = false;
				break; }
			if ( is_array( $key ) ) {
				$validated = $this->validateParams( $params[ $index ], $key, $validated );
			}
		}
		return $validated;
	}

}
