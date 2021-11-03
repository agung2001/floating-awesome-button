<?php
	$count      = count( $fab_to_display );
	$multipier  = $count >= 3 ? 45 : 30;
	$css_height = ( $count * $multipier );
?>
<!--float button-->
<div class="fab-container">
	<div class="fab-floating-button">
		<input type="checkbox" />
		<div class="ripple"></div>
		<div class="ripple" style="animation-delay: 0.6s;"></div>
		<div class="fab">
			<em class="fas fa-ellipsis-h"></em>
		</div>
		<div class="fac animate__animated" style="height:<?php echo 30 + esc_attr( $css_height ); ?>px;top:<?php echo -40 - esc_attr( $css_height ); ?>px">
			<?php foreach ( $fab_to_display as $fab_item ) : ?>
				<a id="fab-link-<?php echo esc_attr( $fab_item->getID() ); ?>"
				   data-id="<?php echo esc_attr( $fab_item->getID() ); ?>"
				   data-type="<?php echo esc_attr( $fab_item->getType() ); ?>"
					<?php echo ( esc_attr( $fab_item->getHotkey() ) ) ? sprintf( ' data-hotkey="%s" ', esc_attr( $fab_item->getHotkey() ) ) : ''; ?>
					<?php echo ( 'link' != esc_attr( $fab_item->getType() ) ) ? 'data-modal="fab-modal-' . esc_attr( $fab_item->getID() ) . '"' : ''; ?>
					<?php echo ( 'link' == esc_attr( $fab_item->getType() ) && esc_attr( $fab_item->getLinkBehavior() ) ) ? sprintf( 'target="_fab_window_%s"', esc_attr( $fab_item->getID() ) ) : ''; ?>
					<?php if ( 'link' == esc_attr( $fab_item->getType() ) ) : ?>
						href="<?php echo esc_url( $fab_item->getLink() ); ?>"
						class="fab-links cursor-pointer"
					<?php else : ?>
						class="fab-links  cursor-pointer"
					<?php endif; ?>
				>
					<em
						title="<?php echo esc_attr( get_the_title( $fab_item->getID() ) ); ?>"
						class="<?php echo empty( esc_attr( $fab_item->getIconClass() ) ) ? 'fas fa-circle' : esc_attr( $fab_item->getIconClass() ); ?>"
					>
					</em>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</div><!--.fab-container-->

<!--Modal-->
<?php foreach ( $fab_to_display as $fab_item ) : ?>
	<?php
	if ( 'link' == $fab_item->getType() ) {
		continue;} // Bypass if fab type is link
	?>
	<div class="fab-container">
		<div
			id="fab-modal-<?php echo esc_attr( $fab_item->getID() ); ?>"
			class="hidden modal" data-title="<?php echo esc_attr( $fab_item->getTitle() ); ?>"
			data-icon="<?php echo ( $fab_item->getIconClass() ) ? esc_attr( $fab_item->getIconClass() ) : 'fas fa-circle'; ?>">
				<div class="w-full overflow-hidden">
					<?php if ( 'modal' == $fab_item->getType() ) : ?>
						<?php echo do_shortcode( get_post_field( 'post_content', $fab_item->getID() ) ); ?>
					<?php elseif ( 'widget' == $fab_item->getType() ) : ?>
						<?php dynamic_sidebar( 'fab-widget-' . $fab_item->getSlug() ); ?>
					<?php elseif ( 'widget_content' == $fab_item->getType() ) : ?>
						<?php echo do_shortcode( get_post_field( 'post_content', $fab_item->getID() ) ); ?>
						<?php dynamic_sidebar( 'fab-widget-' . $fab_item->getSlug() ); ?>
					<?php endif; ?>
				</div>
		</div>
	</div>
<?php endforeach; ?>
