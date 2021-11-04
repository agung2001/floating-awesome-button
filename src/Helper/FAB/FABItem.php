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
	 * @var      array    $icon_class    icon_class
	 */
	protected $icon_class;

	/**
	 * @access   protected
	 * @var      string    $type    type
	 */
	protected $type;

	/**
	 * @access   protected
	 * @var      string    $link    link
	 */
	protected $link;

	/**
	 * @access   protected
	 * @var      string    $linkBehavior    linkBehavior
	 */
	protected $linkBehavior;

	/**
	 * @access   protected
	 * @var      string    $hotkey    hotkey
	 */
	protected $hotkey;

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

	/** format fab item to send to view
	 *
	 * @return array [ 'icon_class'=>'','type'=>'','id'=>'',]
	 */
	public function __construct( $ID ) {
		/** Get Plugin Instance */
		$plugin   = \Fab\Plugin::getInstance();
		$this->WP = $plugin->getWP();

		/** Construct Class */
		$this->ID              = $ID;
		$this->to_be_displayed = false;
		$this->title           = get_post_field( 'post_title', $this->ID );
		$this->slug            = get_post_field( 'post_name', $this->ID );
		$this->icon_class      = $this->WP->get_post_meta( $this->ID, FABMetaboxSetting::$post_metas['icon_class']['meta_key'], true );
		$this->icon_class      = $this->getIconClass();
		$this->type            = $this->WP->get_post_meta( $this->ID, FABMetaboxSetting::$post_metas['type']['meta_key'], true );
		$this->link            = $this->WP->get_post_meta( $this->ID, FABMetaboxSetting::$post_metas['link']['meta_key'], true );
		$this->link            = ( $this->link && is_string( $this->link ) ) ? $this->link : '';
		$this->linkBehavior    = $this->WP->get_post_meta( $this->ID, FABMetaboxSetting::$post_metas['link_behavior']['meta_key'], true );
		$this->hotkey          = $this->WP->get_post_meta( $this->ID, FABMetaboxSetting::$post_metas['hotkey']['meta_key'], true );
		$this->locations       = $this->WP->get_post_meta( $this->ID, FABMetaboxLocation::$post_metas['locations']['meta_key'], true );
		$this->locations       = ( $this->locations ) ? json_decode( $this->locations, true ) : array();

		/** Auto Match */
		$this->match();
	}

	/** Match current displayed post by locations setting on cpt fab items
	 *
	 * @param array $fab_locations post_meta 'fab_locations'
	 * @return void
	 */
	public function match() {
		global $post;

		/** Loop location config */
		foreach ( $this->locations as $location ) {
			if ( $this->to_be_displayed ) {
				break; /** Break when rules exists/found */
			}
			/** example content of $fab_location [{'type':'post','operator'=>'==',value:'post'}] */
			if ( isset( $post->post_type ) && 'post_type' == $location['type'] ) {
				/** if matched by post_type, then break */
				$this->to_be_displayed = $this->match_operator_and_value(
					$location['operator'], // Operator ==, !=
					$post->post_type, // Source Value
					$location['value'] // Compared Value
				);
			}
			/** example content of $fab_location [{'type':'post','operator'=>'==',value:'post'}] */
			elseif ( is_single() && 'page' == $location['type'] ) {
				/** if matched by post_type, then break */
				$this->to_be_displayed = $this->match_operator_and_value(
					$location['operator'], // Operator ==, !=
					$post->ID, // Source Value
					$location['value'] // Compared Value
				);
			}
		}
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
	 * Render FAB by type
	 *
	 * @return void
	 */
	public function render() {
		if ( 'modal' === $this->getType() ) {
			$this->render_content();
		} elseif ( 'widget' === $this->getType() ) {
			$this->render_widget();
		} elseif ( 'widget_content' === $this->getType() ) {
			$this->render_content();
			$this->render_widget();
		}
	}

	/**
	 * Render FAB Content
	 *
	 * @return void
	 */
	public function render_content() {
		$content = get_post_field( 'post_content', $this->getID() ); // Get post content.
		$content = wp_kses_post( $content ); // Esc content.
		echo do_shortcode( $content ); // Output the content.
	}

	/**
	 * Render FAB Widget
	 */
	public function render_widget() {
		dynamic_sidebar( 'fab-widget-' . $this->getSlug() );
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
		return ( $this->icon_class ) ? $this->icon_class : 'fas fa-circle';
	}

	/**
	 * @param array $icon_class
	 */
	public function setIconClass( $icon_class ): void {
		$this->icon_class = $icon_class;
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

}
