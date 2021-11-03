<?php
/**
 * Metabox Setting
 *
 * @package FAB
 */
?>

<!-- START: ".fab-container" -->
<div class="fab-container metabox-settings">

	<!--.grid, Field Behaviour Display-->
	<div class="grid grid-cols-5 gap-4 py-4">
		<div class="font-medium text-gray-600 pt-2">
			Type
		</div>
		<div class="col-span-4">
			<select name="fab_setting_type" class="select2">
				<?php foreach ( $fab_metabox_setting_types as $key => $label ) : ?>
					<option value="<?php echo esc_attr( $key ); ?>" <?php echo ( esc_attr( $key ) === esc_attr( $fab->getType() ) ) ? 'selected="selected"' : ''; ?>>
						<?php echo esc_attr( $label ); ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>
	</div><!--.grid-->

	<!--.grid, Field Link-->
	<div class="grid grid-cols-5 gap-4 py-4 link-info" style="<?php echo 'link' !== esc_attr( $fab->getType() ) ? 'display:none' : ''; ?>">
		<div class="font-medium text-gray-600 pt-2">
			Link Address
		</div>
		<div class="col-span-4">
			<input type="url" name="fab_setting_link" <?php echo 'link' === esc_attr( $fab->getType() ) ? 'required="required"' : ''; ?>
				placeholder="http://example.com"
				class="border border-gray-200 py-2 px-3 text-grey-darkest w-full" 
				value="<?php echo empty( esc_attr( $fab->getLink() ) ) ? '' : esc_attr( $fab->getLink() ); ?>" />
		</div>
	</div><!--.grid-->

	<!--.grid, Field Link Behaviour-->
	<div class="grid grid-cols-5 gap-4 py-4 link-info" style="<?php echo 'link' !== esc_attr( $fab->getType() ) ? 'display:none' : ''; ?>">
		<div class="font-medium text-gray-600 pt-2"></div>
		<div class="col-span-4">
			<label>
				<input type="checkbox" name="fab_setting_link_behavior"
					class="border border-gray-200 py-2 px-3 text-grey-darkest"
					<?php echo ( esc_attr( $fab->getLinkBehavior() ) ) ? 'checked="checked"' : ''; ?>
					value="1" /> Open In new Window
			</label>
		</div>
	</div><!--.grid-->

	<!--.grid, Function Key-->
	<?php if ( $this->Helper->isPremiumPlan() ) : ?>
		<div class="grid  grid-cols-5 gap-4 py-4">
			<div class="font-medium text-gray-600 pt-2">
				Function Key
			</div>
			<div class="col-span-4">
				<select name="fab_setting_hotkey" class="select2" placeholder="Function Key">
					<option value="">--choose--</option>
					<?php for ( $i = 1;$i <= 12;$i++ ) : ?>
					<option value="f<?php echo esc_attr( $i ); ?>" <?php echo ( 'f' . esc_attr( $i ) == esc_attr( $fab->getHotkey() ) ) ? 'selected="selected"' : ''; ?>>
						F<?php echo esc_attr( $i ); ?>
					</option>
					<?php endfor; ?>
				</select>
			</div>
		</div><!--.grid-->
	<?php endif; ?>

	<!--.grid, Field Icon Class-->
	<div class="grid grid-cols-5 gap-4 py-4">
		<div class="font-medium text-gray-600 pt-2">
			Icon Class
		</div>
		<div class="col-span-4">
			<input type="text" name="fab_setting_icon_class"
				class="border border-gray-200 py-2 px-3 text-grey-darkest w-full " placeholder="fas fa-circle"
				value="<?php echo empty( esc_attr( $fab->getIconClass() ) ) ? '' : esc_attr( $fab->getIconClass() ); ?>" />
			<em class="field-info block mt-2">
				Please refer to
				<code><a href="https://fontawesome.com/v5.15/icons/" target="_blank">Font Awesome</a></code>
				to see the icon class
			</em>
		</div>
	</div><!--.grid-->
</div>
<!-- END: ".fab-container" -->

<script type="text/javascript">
	jQuery(function($) {
		window.FAB_METABOX_SETTING.init();
	});
</script>
