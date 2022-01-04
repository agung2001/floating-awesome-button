<?php

namespace Fab\Helper;

! defined( 'WPINC ' ) or die;

/**
 * Plugin hooks in a backend
 * setComponent
 *
 * @package    Fab
 * @subpackage Fab/Controller
 */

use Fab\Metabox\FABMetaboxLocation;
use Fab\Metabox\FABMetaboxSetting;
use Fab\Metabox\FABMetaboxDesign;
use Fab\Metabox\FABMetaboxTrigger;
use Fab\Module\FABModuleAuthLogin;
use Fab\Module\FABModuleAuthLogout;
use Fab\Module\FABModuleSearch;

class FABItem {

	/**
	 * @access   protected
	 * @var      int    $ID    ID
	 */
	protected $ID;

	/**
	 * @access   protected
	 * @var      string    $title    Title
	 */
	protected $title;

	/**
	 * @access   protected
	 * @var      array    $slug    slug
	 */
	protected $slug;

	/**
	 * @access   protected
	 * @var      string    $status    status
	 */
	protected $status;

	/**
	 * @access   protected
	 * @var      array    $icon_class    icon_class
	 */
	protected $icon_class;

	/**
	 * @access   protected
	 * @var      array    $responsive    responsive
	 */
	protected $responsive = array();

	/**
	 * @access   protected
	 * @var      array    $size    design
	 */
	protected $size = array();

	/**
	 * @access   protected
	 * @var      string    $type    type
	 */
	protected $type;

	/**
	 * @access   protected
	 * @var      string    $link    link
	 */
	protected $link = '';

	/**
	 * @access   protected
	 * @var      string    $linkBehavior    linkBehavior
	 */
	protected $linkBehavior = false;

	/**
	 * @access   protected
	 * @var      string    $hotkey    hotkey
	 */
	protected $hotkey;

    /**
     * @access   protected
     * @var      array    $animation    animation
     */
    protected $animation = array();

    /**
     * @access   protected
     * @var      FABModal    $modal    modal
     */
    protected $modal;

	/**
	 * @access   protected
	 * @var      array    $trigger    trigger
	 */
	protected $trigger = array();

    /**
     * @access   protected
     * @var      array    $template    template
     */
    protected $template = array();

    /**
     * @access   protected
     * @var      array    $tooltip    tooltip
     */
    protected $tooltip = array();

	/**
	 * @access   protected
	 * @var      array    $locations    locations setting
	 */
	protected $locations;

	/**
	 * @access   protected
	 * @var      bool    $to_be_displayed    to be displayed or not
	 */
	protected $to_be_displayed;

	/**
	 * @access   protected
	 * @var      string    $builder    builder (classic, guttenberg, elementor, beaver builder, etc)
	 */
	protected $builder;

	/** format fab item to send to view
	 *
	 * @return array [ 'icon_class'=>'','type'=>'','id'=>'',]
	 */
	public function __construct( int $ID ) {
		/** Get Plugin Instance */
		$plugin   = \Fab\Plugin::getInstance();
		$this->WP = $plugin->getWP();
		$options  = $plugin->getConfig()->options;

		/** Construct Class */
		$this->ID              = $ID;
		$this->to_be_displayed = true;
		$this->title           = get_post_field( 'post_title', $this->ID );
		$this->slug            = get_post_field( 'post_name', $this->ID );
		$this->status          = get_post_field( 'post_status', $this->ID );
        $this->modal           = new FABModal($this->ID);
		$this->icon_class      = $this->WP->get_post_meta( $this->ID, FABMetaboxDesign::$post_metas['icon_class']['meta_key'], true );
		$this->icon_class      = $this->getIconClass();
		$this->size            = array(
			'type'   => ( $this->WP->get_post_meta( $this->ID, FABMetaboxDesign::$post_metas['size_type']['meta_key'], true ) ) ?
				$this->WP->get_post_meta( $this->ID, FABMetaboxDesign::$post_metas['size_type']['meta_key'], true ) : 'medium',
			'custom' => ( $this->WP->get_post_meta( $this->ID, FABMetaboxDesign::$post_metas['size_custom']['meta_key'], true ) ) ?
				$this->WP->get_post_meta( $this->ID, FABMetaboxDesign::$post_metas['size_custom']['meta_key'], true ) : '',
		);
		$this->type            = $this->WP->get_post_meta( $this->ID, FABMetaboxSetting::$post_metas['type']['meta_key'], true );
		$this->hotkey          = $this->WP->get_post_meta( $this->ID, FABMetaboxSetting::$post_metas['hotkey']['meta_key'], true );
		$this->hotkey          = ($this->hotkey==='none') ? '' : $this->hotkey;

        /** Animation */
        $this->animation = $this->WP->get_post_meta( $this->ID, FABMetaboxDesign::$post_metas['animation']['meta_key'], true );
        $this->animation = ( $this->animation ) ? $this->animation : FABMetaboxDesign::$input['fab_design_animation']['default'];

		/** Responsive */
		$this->responsive = $this->WP->get_post_meta( $this->ID, FABMetaboxDesign::$post_metas['responsive']['meta_key'], true );
		$this->responsive = ( $this->responsive ) ? $this->responsive : FABMetaboxDesign::$input['fab_design_responsive']['default'];

		/** Trigger */
		$this->trigger = $this->WP->get_post_meta( $this->ID, FABMetaboxTrigger::$post_metas['trigger']['meta_key'], true );
		$this->trigger = ( $this->trigger ) ? $this->trigger : FABMetaboxTrigger::$input['fab_trigger']['default'];

        /** Template */
        $this->template = $this->WP->get_post_meta( $this->ID, FABMetaboxDesign::$post_metas['template']['meta_key'], true );
        $this->template = ( $this->template ) ? $this->template : FABMetaboxDesign::$input['fab_design_template']['default'];

        /** Tooltip */
        $this->tooltip = $this->WP->get_post_meta( $this->ID, FABMetaboxDesign::$post_metas['tooltip']['meta_key'], true );
        $this->tooltip = ( $this->tooltip ) ? $this->tooltip : FABMetaboxDesign::$input['fab_design_tooltip']['default'];

		/** Location */
		$this->locations = $this->WP->get_post_meta( $this->ID, FABMetaboxLocation::$post_metas['locations']['meta_key'], true );
		$this->locations = ( $this->locations ) ? json_decode( $this->locations, true ) : array();

		/** Grab Link */
		if ( $this->type === 'link' ) {
			$this->link         = $this->WP->get_post_meta( $this->ID, FABMetaboxSetting::$post_metas['link']['meta_key'], true );
			$this->link         = ( $this->link && is_string( $this->link ) ) ? $this->link : '';
			$this->linkBehavior = $this->WP->get_post_meta( $this->ID, FABMetaboxSetting::$post_metas['link_behavior']['meta_key'], true );
		} elseif ( $this->type === 'auth_logout' ) {
			$this->link = wp_logout_url( home_url() );
		}

		/** Extra Function */
		$this->match(); // Auto Match Location.
		$this->detect_builder(); // Detect content builder
	}

	/** Match current displayed post by locations setting on cpt fab items
	 *
	 * @param array $fab_locations post_meta 'fab_locations'
	 * @return void
	 */
	public function match() {
		/** Validate */
		if ( ! $this->locations ) {
			return;
		}

		/** Grab Data */
		global $post;

		/** Loop location config */
		$validations = array();
		foreach ( $this->locations as $location ) {
			/** Grab Data */
			$condition = array(
				'logic' => ( isset( $location['logic'] ) ) ? $location['logic'] : 'OR',
			);

			/** Rule Check */
			$condition['passed'] = false;
			if ( isset( $post->post_type ) && 'post_type' == $location['type'] ) { // Matched by post type.
				$condition['passed'] = $this->match_operator_and_value(
					$location['operator'], // Operator ==, !=.
					$post->post_type, // Source Value.
					$location['value'] // Compared Value.
				);
			} elseif ( isset( $post->ID ) && is_single() && strpos( $location['type'], 'single_' ) !== false ) { // Matched by ID, single
				$condition['passed'] = $this->match_operator_and_value(
					$location['operator'], // Operator ==, !=.
					$post->ID, // Source Value, Current Post ID.
					intval( $location['value'] ) // Compared Value, Page ID.
				);
			} elseif ( 'user_session' == $location['type'] && $location['value'] === 'user_session_logged_in' ) { // Matched by User Session
				$condition['passed'] = $this->match_operator_and_value(
					'==', // Operator always == to check logged in or not.
					is_user_logged_in(), // Source Value, Current User Role.
					( $location['operator'] === '==' ) ? true : false // Compared Value, Page ID.
				);
			}

			/** Store Validations */
			$validations[] = $condition;
		}

		/** Validate Logic (OR, AND) */
		$to_be_displayed = $validations[0]['passed'];
		if ( count( $validations ) > 1 ) {
			for ( $i = 1; $i < count( $validations ); $i++ ) {
				if ( $validations[ $i ]['logic'] === 'OR' ) {
					$to_be_displayed = $to_be_displayed || $validations[ $i ]['passed'];
				} elseif ( $validations[ $i ]['logic'] === 'AND' ) {
					$to_be_displayed = $to_be_displayed && $validations[ $i ]['passed'];
				}
			}
		}
		 $this->to_be_displayed = $to_be_displayed;
	}

	/** Match locations setting when current displayed content are page
	 *
	 * @param string $operator '==' or '!='
	 * @param int    $page_id seting that saved on meta fab_locations
	 * @return bool
	 */
	public function match_operator_and_value( $operator, $source_value, $compared_value ) {
		/** Match operator equal to */
		if ( '==' === $operator && $source_value === $compared_value ) {
			return true;
		}
		/** Match operator not equal to */
		elseif ( '!=' === $operator && $source_value !== $compared_value ) {
			return true;
		}

		return false;
	}

	/**
	 * Detect content builder
	 */
	public function detect_builder() {
		if ( is_plugin_active( 'elementor/elementor.php' ) && \Elementor\Plugin::instance()->db->is_built_with_elementor( $this->getID() ) ) {
			// Elementor builder
			$this->builder = 'elementor';
		} else { // Default builder
			$this->builder = 'default';
		}
	}

	/**
	 * Render FAB by type
	 *
	 * @return void
	 */
	public function render() {
		if ( 'auth_login' === $this->getType() ) {
			$module = new FABModuleAuthLogin();
			$module->render();
		} elseif ( 'auth_logout' === $this->getType() ) {
			$module = new FABModuleAuthLogout();
			$module->render();
		} elseif ( 'modal' === $this->getType() ) {
			$this->render_content();
		} elseif ( 'modal_widget' === $this->getType() ) {
			$this->render_content();
			$this->render_widget();
		} elseif ( 'search' === $this->getType() ) {
			$module = new FABModuleSearch();
			$module->render();
		} elseif ( 'widget' === $this->getType() ) {
			$this->render_widget();
		}
	}

	/**
	 * Render FAB Content
	 *
	 * @return void
	 */
	public function render_content( $content = '' ) {
		/** Render Elementor */
		if ( $this->builder === 'elementor' ) {
			$content = \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $this->getID() );
		} else {
			$content = get_post_field( 'post_content', $this->getID() ); // Get post content.
			$content = wp_kses_post( $content ); // Esc content.
		}

		/** Output the content */
		echo do_shortcode( $content );
	}

	/**
	 * Render FAB Widget
	 */
	public function render_widget() {
		dynamic_sidebar( sprintf( 'fab-widget-%s', $this->getSlug() ) );
	}

	/**
	 * @return int
	 */
	public function getID(): int {
		return $this->ID;
	}

	/**
	 * @param int $ID
	 */
	public function setID( int $ID ): void {
		$this->ID = $ID;
	}

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param string $title
	 */
	public function setTitle( $title ): void {
		$this->title = $title;
	}

	/**
	 * @return string
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * @param string $status
	 */
	public function setStatus( $status ): void {
		$this->status = $status;
	}

	/**
	 * @return array
	 */
	public function getSlug() {
		return $this->slug;
	}

	/**
	 * @param array $slug
	 */
	public function setSlug( $slug ): void {
		$this->slug = $slug;
	}

	/**
	 * @return array
	 */
	public function getIconClass() {
		/** TODO: OLDCODE must be removed next major version */
		$oldData = $this->WP->get_post_meta( $this->ID, 'fab_setting_icon_class', true );
		if ( $oldData ) {
			$this->WP->update_post_meta( $this->ID, FABMetaboxDesign::$post_metas['icon_class']['meta_key'], $oldData );
		}
		/** TODO: OLDCODE must be removed next major version */

		return ( $this->icon_class ) ? $this->icon_class : 'fas fa-circle';
	}

	/**
	 * @param array $icon_class
	 */
	public function setIconClass( $icon_class ): void {
		$this->icon_class = $icon_class;
	}

	/**
	 * @return array
	 */
	public function getResponsive(): array {
		return $this->responsive;
	}

	/**
	 * @param array $responsive
	 */
	public function setResponsive( array $responsive ): void {
		$this->responsive = $responsive;
	}

	/**
	 * @return array
	 */
	public function getSize(): array {
		return $this->size;
	}

	/**
	 * @param array $size
	 */
	public function setSize( array $size ): void {
		$this->size = $size;
	}

	/**
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * @param string $type
	 */
	public function setType( $type ): void {
		$this->type = $type;
	}

	/**
	 * @return string
	 */
	public function getLink() {
		return $this->link;
	}

	/**
	 * @param string $link
	 */
	public function setLink( $link ): void {
		$this->link = $link;
	}

	/**
	 * @return string
	 */
	public function getLinkBehavior() {
		return $this->linkBehavior;
	}

	/**
	 * @param string $linkBehavior
	 */
	public function setLinkBehavior( $linkBehavior ): void {
		$this->linkBehavior = $linkBehavior;
	}

	/**
	 * @return string
	 */
	public function getHotkey() {
		return $this->hotkey;
	}

	/**
	 * @param string $hotkey
	 */
	public function setHotkey( $hotkey ): void {
		$this->hotkey = $hotkey;
	}

    /**
     * @return array
     */
    public function getAnimation()
    {
        return $this->animation;
    }

    /**
     * @param array $animation
     */
    public function setAnimation($animation): void
    {
        $this->animation = $animation;
    }

    /**
     * @return FABModal
     */
    public function getModal(): FABModal
    {
        return $this->modal;
    }

    /**
     * @param FABModal $modal
     */
    public function setModal(FABModal $modal): void
    {
        $this->modal = $modal;
    }

	/**
	 * @return array
	 */
	public function getTrigger(): array {
		return $this->trigger;
	}

	/**
	 * @param array $trigger
	 */
	public function setTrigger( array $trigger ): void {
		$this->trigger = $trigger;
	}

    /**
     * @return array
     */
    public function getTemplate(): array
    {
        return $this->template;
    }

    /**
     * @param array $template
     */
    public function setTemplate(array $template): void
    {
        $this->template = $template;
    }

    /**
     * @return array
     */
    public function getTooltip()
    {
        return $this->tooltip;
    }

    /**
     * @param array $tooltip
     */
    public function setTooltip($tooltip): void
    {
        $this->tooltip = $tooltip;
    }

	/**
	 * @return array
	 */
	public function getLocations(): array {
		return $this->locations;
	}

	/**
	 * @param array $locations
	 */
	public function setLocations( array $locations ): void {
		$this->locations = $locations;
	}

	/**
	 * @return bool
	 */
	public function isToBeDisplayed(): bool {
		return $this->to_be_displayed;
	}

	/**
	 * @param bool $to_be_displayed
	 */
	public function setToBeDisplayed( bool $to_be_displayed ): void {
		$this->to_be_displayed = $to_be_displayed;
	}

	/**
	 * @return string
	 */
	public function getBuilder(): string {
		return $this->builder;
	}

	/**
	 * @param string $builder
	 */
	public function setBuilder( string $builder ): void {
		$this->builder = $builder;
	}

	/** Grab All Assigned Variables */
	public function getVars() {
        $data = get_object_vars( $this );
        $data['modal'] = $this->modal->getVars();
		return $data;
	}

}
