<?php if ( $this->Helper->isPremiumPlan() ) : ?>
    <!--.grid, Field Modal Theme-->
    <div class="grid grid-cols-5 gap-4 py-4">
        <div class="font-medium text-gray-600 pt-2">
            Theme
        </div>
        <div class="col-span-4">
            <select id="field_option_design_modal_theme"
                    name="fab_modal_theme[id]"
                    class="field_option_design_modal_theme select2"
                    data-selected="<?php echo isset( $fab->getModal()->getTheme()['id'] ) ? esc_attr( $fab->getModal()->getTheme()['id'] ) : 'blank'; ?>">
            </select>
        </div>
    </div><!--.grid-->
<?php endif; ?>

<!--.grid, Field Modal Size-->
<div class="grid grid-cols-5 gap-4 py-4">
    <div class="font-medium text-gray-600 pt-2">
        Size
    </div>
    <div class="col-span-4">
        <select id="field_option_design_modal_size"
                name="fab_design_size_type"
                class="field_option_design_modal_size select2"
                data-selected="<?php echo isset( $fab->getSize()['type'] ) ? esc_attr( $fab->getSize()['type'] ) : 'medium'; ?>">
        </select>
    </div>
</div><!--.grid-->

<!--.grid, Field Modal Custom-->
<div id="setting_design_custom_size" class="grid grid-cols-5 gap-4 py-4">
    <div class="font-medium text-gray-600 pt-2">
        <label for="field_option_design_modal_custom_size">Custom Size</label>
    </div>
    <div class="col-span-4">
        <input type="text"
               id="field_option_design_modal_custom_size"
               name="fab_design_size_custom"
               class="w-full border-gray-200 p-2"
               placeholder="Custom Size %, px, em"
               value="<?php echo isset( $fab->getSize()['custom'] ) ? esc_attr( $fab->getSize()['custom'] ) : '' ?>"
        >
    </div>
</div>

<!--.grid, Field Responsive-->
<div class="grid grid-cols-5 gap-4 py-4">
    <div class="font-medium text-gray-600 pt-2">
        Navigation
    </div>
    <div class="col-span-4">
        <div class="flex">
            <div class="flex">
                <label for="switch_design_navigation_backgroundDismiss" class="flex cursor-pointer">
                    <div class="relative">
                        <input
                                type="checkbox"
                                id="switch_design_navigation_backgroundDismiss"
                                class="option_settings switch sr-only"
                                data-option="fab_modal_navigation_backgroundDismiss"
                            <?php echo ( $fab->getModal()->getNavigation()['backgroundDismiss'] ) ? 'checked' : ''; ?>
                        >
                        <div class="block bg-gray-300 w-10 h-6 rounded-full"></div>
                        <div class="fab absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition"></div>
                    </div>
                </label>
                <input type="hidden" id="fab_modal_navigation_backgroundDismiss" name="fab_modal_navigation[backgroundDismiss]"
                       class="border border-gray-200 py-2 px-3 text-grey-darkest"
                       value="<?php echo ( $fab->getModal()->getNavigation()['backgroundDismiss'] ) ? 'true' : ''; ?>" />
                <span class="pl-2" style="padding-top:2px;">backgroundDismiss</span>
            </div>

            <div class="flex pl-4">
                <label for="switch_design_navigation_buttons_maximize" class="flex cursor-pointer">
                    <div class="relative">
                        <input
                                type="checkbox"
                                id="switch_design_navigation_buttons_maximize"
                                class="option_settings switch sr-only"
                                data-option="fab_modal_navigation_buttons_maximize"
                            <?php echo ( $fab->getModal()->getNavigation()['buttons']['maximize'] ) ? 'checked' : ''; ?>
                        >
                        <div class="block bg-gray-300 w-10 h-6 rounded-full"></div>
                        <div class="fab absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition"></div>
                    </div>
                </label>
                <input type="hidden" id="fab_modal_navigation_buttons_maximize" name="fab_modal_navigation[buttons][maximize]"
                       class="border border-gray-200 py-2 px-3 text-grey-darkest"
                       value="<?php echo ( $fab->getModal()->getNavigation()['buttons']['maximize'] ) ? 'true' : ''; ?>" />
                <span class="pl-2" style="padding-top:2px;">Button - Maximize</span>
            </div>

            <div class="flex pl-4">
                <label for="switch_design_navigation_draggable" class="flex cursor-pointer">
                    <div class="relative">
                        <input
                                type="checkbox"
                                id="switch_design_navigation_draggable"
                                class="option_settings switch sr-only"
                                data-option="fab_modal_navigation_draggable"
                            <?php echo ( $fab->getModal()->getNavigation()['draggable'] ) ? 'checked' : ''; ?>
                        >
                        <div class="block bg-gray-300 w-10 h-6 rounded-full"></div>
                        <div class="fab absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition"></div>
                    </div>
                </label>
                <input type="hidden" id="fab_modal_navigation_draggable" name="fab_modal_navigation[draggable]"
                       class="border border-gray-200 py-2 px-3 text-grey-darkest"
                       value="<?php echo ( $fab->getModal()->getNavigation()['draggable'] ) ? 'true' : ''; ?>" />
                <span class="pl-2" style="padding-top:2px;">Draggable</span>
            </div>

            <div class="flex pl-4">
                <label for="switch_design_navigation_escapeKey" class="flex cursor-pointer">
                    <div class="relative">
                        <input
                                type="checkbox"
                                id="switch_design_navigation_escapeKey"
                                class="option_settings switch sr-only"
                                data-option="fab_modal_navigation_escapeKey"
                            <?php echo ( $fab->getModal()->getNavigation()['escapeKey'] ) ? 'checked' : ''; ?>
                        >
                        <div class="block bg-gray-300 w-10 h-6 rounded-full"></div>
                        <div class="fab absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition"></div>
                    </div>
                </label>
                <input type="hidden" id="fab_modal_navigation_escapeKey" name="fab_modal_navigation[escapeKey]"
                       class="border border-gray-200 py-2 px-3 text-grey-darkest"
                       value="<?php echo ( $fab->getModal()->getNavigation()['escapeKey'] ) ? 'true' : ''; ?>" />
                <span class="pl-2" style="padding-top:2px;">escapeKey</span>
            </div>
        </div>
    </div>
</div><!--.grid-->

<div class="grid grid-cols-5 gap-4 py-4">
    <div class="font-medium text-gray-600 pt-2">
        Content
    </div>
    <div class="col-span-4">
        <div class="flex">
            <label for="switch_design_content_overflow" class="flex cursor-pointer">
                <div class="relative">
                    <input
                            type="checkbox"
                            id="switch_design_content_overflow"
                            class="option_settings switch sr-only"
                            data-option="fab_modal_layout_content_overflow"
                        <?php echo ( $fab->getModal()->getLayout()['content']['overflow'] ) ? 'checked' : ''; ?>
                    >
                    <div class="block bg-gray-300 w-10 h-6 rounded-full"></div>
                    <div class="fab absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition"></div>
                </div>
            </label>
            <input type="hidden" id="fab_modal_layout_content_overflow" name="fab_modal_layout[content][overflow]"
                   class="border border-gray-200 py-2 px-3 text-grey-darkest"
                   value="<?php echo ( $fab->getModal()->getLayout()['content']['overflow'] ) ? 'true' : ''; ?>" />
            <span class="pl-2" style="padding-top:2px;">Overflow</span>
        </div>
    </div>
</div>
<!--.grid-->

<?php if ( $this->Helper->isPremiumPlan() ) : ?>
    <div class="py-4 my-4 border-b border-gray-200">
        <span class="text-lg">Animation</span>
        <div class="text-gray-400">
            <em class="field-info">
                To see animation reference you can go to
                <code><a href="https://daneden.github.io/animate.css/" target="_blank">Animate.css</a></code>
            </em>
        </div>
    </div>

    <div class="grid grid-cols-5 gap-4 py-4">
        <div class="font-medium text-gray-600 pt-2">
            In
        </div>
        <div class="col-span-4">
            <select name="fab_design_animation[modal][in]"
                    class="field_option_animation_element select2"
                    data-selected="<?php echo isset($fab->getAnimation()['modal']['in']) ? esc_attr( $fab->getAnimation()['modal']['in'] ) : 'fadeIn'; ?>"
            >
            </select>
        </div>
    </div>

    <div class="grid grid-cols-5 gap-4 py-4">
        <div class="font-medium text-gray-600 pt-2">
            Out
        </div>
        <div class="col-span-4">
            <select name="fab_design_animation[modal][out]"
                    class="field_option_animation_element select2"
                    data-selected="<?php echo isset($fab->getAnimation()['modal']['out']) ? esc_attr( $fab->getAnimation()['modal']['out'] ) : 'fadeOut'; ?>"
            >
            </select>
        </div>
    </div>
<?php endif; ?>

<div class="py-4 my-4 border-b border-gray-200">
    <span class="text-lg">Background</span>
    <div class="text-gray-400">
        <em class="field-info">Modal background layer</em>
    </div>
</div>
<!--.grid, Color-->
<div class="grid grid-cols-5 gap-4 py-4">
    <div class="font-medium text-gray-600 pt-2">
        Color
    </div>
    <div class="col-span-4">
        <input type="text"
               id="fab_modal_layout_background_color"
               class="colorpicker" name="fab_modal_layout[background][color]"
               value="<?php echo isset($fab->getModal()->getLayout()['background']['color']) ? esc_attr( $fab->getModal()->getLayout()['background']['color'] ) : ''; ?>">
    </div>
</div>
<!--.grid-->
<!--.grid, Opacity-->
<div class="grid grid-cols-5 gap-4 py-4">
    <div class="font-medium text-gray-600 pt-2">
        Opacity
        (<spand id="fab_modal_layout_background_opacity_label"><?php echo isset($fab->getModal()->getLayout()['background']['opacity']) ? esc_attr( $fab->getModal()->getLayout()['background']['opacity'] ) : '0.5'; ?></spand>)
    </div>
    <div class="col-span-4">
        <input type="range"
               id="fab_modal_layout_background_opacity"
               class="slider" name="fab_modal_layout[background][opacity]" min="0" max="1" step="0.1"
               onChange="window.FAB_PLUGIN.triggerSettingSliderLabel(this)" onmousemove="window.FAB_PLUGIN.triggerSettingSliderLabel(this)"
               value="<?php echo isset($fab->getModal()->getLayout()['background']['opacity']) ? esc_attr( $fab->getModal()->getLayout()['background']['opacity'] ) : '0.5'; ?>">
    </div>
</div>
<!--.grid-->

<div class="py-4 my-4 border-b border-gray-200">
    <span class="text-lg">Spacing</span>
    <div class="text-gray-400">
        <em class="field-info">Content spacing</em>
    </div>
</div>

<!--.grid, Trigger-->
<div class="grid grid-cols-5 gap-4 py-4">
    <div class="font-medium text-gray-600 pt-2">
        Padding
    </div>
    <div class="col-span-4">
        <div class="flex">
            <input id="fab_modal_layout_content_padding_top" name="fab_modal_layout[content][padding][top]"
                   type="number" step="any"
                   class="border border-gray-200 p-2 text-grey-darkest w-20 fab-modal-layout-spacing fab-modal-layout-padding"
                   value="<?php echo isset($fab->getModal()->getLayout()['content']['padding']['top']) ? esc_attr( $fab->getModal()->getLayout()['content']['padding']['top'] ) : 0; ?>"
                   placeholder="Top" data-layout="padding" required>
            <input id="fab_modal_layout_content_padding_right" name="fab_modal_layout[content][padding][right]"
                   type="number" step="any"
                   class="border border-gray-200 p-2 text-grey-darkest w-20 ml-4 fab-modal-layout-spacing fab-modal-layout-padding"
                   value="<?php echo isset($fab->getModal()->getLayout()['content']['padding']['right']) ? esc_attr( $fab->getModal()->getLayout()['content']['padding']['right'] ) : 0; ?>"
                   placeholder="Right" data-layout="padding" required>
            <input id="fab_modal_layout_content_padding_bottom" name="fab_modal_layout[content][padding][bottom]"
                   type="number" step="any"
                   class="border border-gray-200 p-2 text-grey-darkest w-20 ml-4 fab-modal-layout-spacing fab-modal-layout-padding"
                   value="<?php echo isset($fab->getModal()->getLayout()['content']['padding']['bottom']) ? esc_attr( $fab->getModal()->getLayout()['content']['padding']['bottom'] ) : 0; ?>"
                   placeholder="Bottom" data-layout="padding" required>
            <input id="fab_modal_layout_content_padding_left" name="fab_modal_layout[content][padding][left]"
                   type="number" step="any"
                   class="border border-gray-200 p-2 text-grey-darkest w-20 ml-4 fab-modal-layout-spacing fab-modal-layout-padding"
                   value="<?php echo isset($fab->getModal()->getLayout()['content']['padding']['left']) ? esc_attr( $fab->getModal()->getLayout()['content']['padding']['left'] ) : 0; ?>"
                   placeholder="Left" data-layout="padding" required>
            <div class="ml-4 w-20">
                <select
                        name="fab_modal_layout[content][padding][sizing]"
                        class="select2 fab_modal_layout_spacing_sizing"
                        data-selected="<?php echo isset($fab->getModal()->getLayout()['content']['padding']['sizing']) ? esc_attr( $fab->getModal()->getLayout()['content']['padding']['sizing'] ) : 'REM'; ?>"
                >
                    <option value="px">PX</option>
                    <option value="em">EM</option>
                    <option value="%">%</option>
                    <option value="rem">REM</option>
                    <option value="vw">VW</option>
                    <option value="vh">VH</option>
                </select>
            </div>
            <div class="pt-2.5 px-6 ml-4 bg-primary-600 text-white rounded-md cursor-pointer fab-linked-option hover:shadow-md" data-layout="padding">
                <em class="fas fa-link"></em>
            </div>
        </div>
    </div>
</div>
<!--.grid-->

<!--.grid, Trigger-->
<div class="grid grid-cols-5 gap-4 py-4">
    <div class="font-medium text-gray-600 pt-2">
        Margin
    </div>
    <div class="col-span-4">
        <div class="flex">
            <input id="fab_modal_layout_content_margin_top" name="fab_modal_layout[content][margin][top]"
                   type="number" step="any"
                   class="border border-gray-200 p-2 text-grey-darkest w-20 fab-modal-layout-spacing fab-modal-layout-margin"
                   value="<?php echo isset($fab->getModal()->getLayout()['content']['margin']['top']) ? esc_attr( $fab->getModal()->getLayout()['content']['margin']['top'] ) : 0; ?>"
                   placeholder="Top" data-layout="margin" required>
            <input id="fab_modal_layout_content_margin_right" name="fab_modal_layout[content][margin][right]"
                   type="number" step="any"
                   class="border border-gray-200 p-2 text-grey-darkest w-20 ml-4 fab-modal-layout-spacing fab-modal-layout-margin"
                   value="<?php echo isset($fab->getModal()->getLayout()['content']['margin']['right']) ? esc_attr( $fab->getModal()->getLayout()['content']['margin']['right'] ) : 0; ?>"
                   placeholder="Right" data-layout="margin" required>
            <input id="fab_modal_layout_content_margin_bottom" name="fab_modal_layout[content][margin][bottom]"
                   type="number" step="any"
                   class="border border-gray-200 p-2 text-grey-darkest w-20 ml-4 fab-modal-layout-spacing fab-modal-layout-margin"
                   value="<?php echo isset($fab->getModal()->getLayout()['content']['margin']['bottom']) ? esc_attr( $fab->getModal()->getLayout()['content']['margin']['bottom'] ) : 0; ?>"
                   placeholder="Bottom" data-layout="margin" required>
            <input id="fab_modal_layout_content_margin_left" name="fab_modal_layout[content][margin][left]"
                   type="number" step="any"
                   class="border border-gray-200 p-2 text-grey-darkest w-20 ml-4 fab-modal-layout-spacing fab-modal-layout-margin"
                   value="<?php echo isset($fab->getModal()->getLayout()['content']['margin']['left']) ? esc_attr( $fab->getModal()->getLayout()['content']['margin']['left'] ) : 0; ?>"
                   placeholder="Left" data-layout="margin" required>
            <div class="ml-4 w-20">
                <select
                        name="fab_modal_layout[content][margin][sizing]"
                        class="select2 fab_modal_layout_spacing_sizing"
                        data-selected="<?php echo isset($fab->getModal()->getLayout()['content']['margin']['sizing']) ? esc_attr( $fab->getModal()->getLayout()['content']['margin']['sizing'] ) : 'REM'; ?>"
                >
                    <option value="px">PX</option>
                    <option value="em">EM</option>
                    <option value="%">%</option>
                    <option value="rem">REM</option>
                    <option value="vw">VW</option>
                    <option value="vh">VH</option>
                </select>
            </div>
            <div class="pt-2.5 px-6 ml-4 bg-primary-600 text-white rounded-md cursor-pointer fab-linked-option hover:shadow-md" data-layout="margin">
                <em class="fas fa-link"></em>
            </div>
        </div>
    </div>
</div>
<!--.grid-->