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
			<select name="fab_setting_type" id="fab_setting_type" class="select2" data-selected="<?php echo esc_attr( $fab->getType() ); ?>"></select>
		</div>
	</div><!--.grid-->

	<!--.grid, Field Link-->
	<div class="grid grid-cols-5 gap-4 py-4 fab-type-link" style="<?php echo 'link' !== esc_attr( $fab->getType() ) ? 'display:none' : ''; ?>">
		<div class="font-medium text-gray-600 pt-2">
			Link Address
		</div>
		<div class="col-span-4">
			<input type="url" name="fab_setting_link" <?php echo 'link' === esc_attr( $fab->getType() ) ? 'required="required"' : ''; ?>
				placeholder="http://example.com"
				class="border border-gray-200 py-2 px-3 text-grey-darkest w-full" 
				value="<?php echo empty( esc_attr( $fab->getLink() ) ) ? '' : esc_attr( $fab->getLink() ); ?>" />
            
            <div class="pt-4 flex">
                <label for="switch_setting_link_behavior" class="flex cursor-pointer">
                    <div class="relative">
                        <input
                                type="checkbox"
                                id="switch_setting_link_behavior"
                                class="option_settings switch sr-only"
                                data-option="fab_setting_link_behavior"
                            <?php echo ( $fab->getLinkBehavior() ) ? 'checked' : ''; ?>
                        >
                        <div class="block bg-gray-300 w-10 h-6 rounded-full"></div>
                        <div class="fab absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition"></div>
                    </div>
                </label>
                <input type="hidden" id="fab_setting_link_behavior" name="fab_setting_link_behavior"
                       class="border border-gray-200 py-2 px-3 text-grey-darkest"
                       value="<?php echo ( $fab->getLinkBehavior() ) ? esc_attr( $fab->getLinkBehavior() ) : ''; ?>" />
                <span class="pl-2" style="padding-top:2px;">Open link in new tab</span>
            </div>
		</div>
	</div><!--.grid-->

	<?php if ( $this->Helper->isPremiumPlan() ) : ?>
	    <!--.grid, Hotkey-->
		<div class="grid grid-cols-5 gap-4 py-4">
			<div class="font-medium text-gray-600 pt-2">
                Hotkey
			</div>
			<div class="col-span-4">
				<select id="fab_setting_hotkey" name="fab_setting_hotkey" class="select2" data-selected="<?php echo esc_attr( $fab->getHotkey() ); ?>"></select>
                <div class="text-gray-400 mt-2">
                    <em class="field-info">
                        To see hotkey reference you can go to
                        <code><a href="https://rawgit.com/jeresig/jquery.hotkeys/master/test-static-01.html" target="_blank">jQuery Hotkeys</a></code>.
                    </em>
                </div>
			</div>
		</div>
	    <!--.grid-->
	<?php endif; ?>
</div>
<!-- END: ".fab-container" -->

<script type="text/javascript">
	jQuery(function($) {
		window.FAB_METABOX_SETTING.init();
	});
</script>
