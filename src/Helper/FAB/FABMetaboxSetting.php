<?php

namespace Fab\Helper;

! defined( 'WPINC ' ) or die;

/**
 * Plugin hooks in a backend
 *
 * @package    Fab
 * @subpackage Fab/Controller
 */

use Fab\Wordpress\Model\Metabox;

class FABMetaboxSetting extends Metabox {

	/** FAB Metabox Settings */
	public static $types = array(
		'modal'          => 'Modal',
		'link'           => 'Link',
		'widget'         => 'Widget',
		'widget_content' => 'Content + Widget',
	);

	/** $_POST input */
	public static $input = array(
		'fab_setting_type'          => array(
			'default' => '',
		),
		'fab_setting_link'          => array(
			'default' => '',
		),
		'fab_setting_icon_class'    => array(
			'default' => 'fas fa-circle',
		),
		'fab_setting_link_behavior' => array(
			'default' => '',
		),
		'fab_setting_hotkey'        => array(
			'default' => '',
		),
	);

	/** FAB Metabox Post Metas */
	public static $post_metas = array(
		'type'          => array( 'meta_key' => 'fab_setting_type' ),
		'link'          => array( 'meta_key' => 'fab_setting_link' ),
		'icon_class'    => array( 'meta_key' => 'fab_setting_icon_class' ),
		'link_behavior' => array( 'meta_key' => 'fab_setting_link_behavior' ),
		'hotkey'        => array( 'meta_key' => 'fab_setting_hotkey' ),
	);

	/** Constructor */
	public function __construct() {
		$plugin   = \Fab\Plugin::getInstance();
		$this->WP = $plugin->getWP();
	}

	/** Sanitize */
	public function sanitize() {
		$input = self::$input;

		/** Sanitized input */
		$params = array();
		foreach ( $_POST as $key => $value ) {
			if ( isset( $input[ $key ] ) && $params[ $key ] ) {
				$params[ $key ] = sanitize_text_field( $value );
			}
		}

		$this->params = $params;
	}

	/** SetDefaultInput */
	public function setDefaultInput() {
		/** Default Input Function */
		$input = self::$input;
		foreach ( $input as $key => $value ) {
			if ( ! $this->params[ $key ] && $value['default'] ) {
				$this->params[ $key ] = $value['default'];
			}
		}

		/** Special Case */
		$this->params['fab_setting_link_behavior'] = ( $this->params['fab_setting_type'] == 'link' ) ?
			$this->params['fab_setting_link_behavior'] : '';
	}

	/** Save data to database */
	public function save() {
		global $post;
		foreach ( $this->params as $key => $value ) {
			$this->WP->update_post_meta( $post->ID, $key, $value );
		}
	}

}
