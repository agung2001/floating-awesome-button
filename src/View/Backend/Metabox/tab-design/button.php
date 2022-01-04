<?php
/**
 * Metabox Design - Button Tab
 */
$fab_design = ( isset( $options->fab_design ) ) ?
    $options->fab_design : $this->Plugin->getConfig()->default->fab_design;
?>

<?php if ( $this->Helper->isPremiumPlan() ) : ?>

    <!--.grid, Field Responsive-->
    <div class="grid grid-cols-5 gap-4 py-4">
        <div class="font-medium text-gray-600 pt-2">
            Show in
        </div>
        <div class="col-span-4 flex">
            <div class="flex">
                <label for="switch_design_responsive_mobile" class="flex cursor-pointer">
                    <div class="relative">
                        <input
                                type="checkbox"
                                id="switch_design_responsive_mobile"
                                class="option_settings switch sr-only"
                                data-option="fab_design_responsive_mobile"
                            <?php echo ( $fab->getResponsive()['device']['mobile'] ) ? 'checked' : ''; ?>
                        >
                        <div class="block bg-gray-300 w-10 h-6 rounded-full"></div>
                        <div class="fab absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition"></div>
                    </div>
                </label>
                <input type="hidden" id="fab_design_responsive_mobile" name="fab_design_responsive[device][mobile]"
                       class="border border-gray-200 py-2 px-3 text-grey-darkest"
                       value="<?php echo ( $fab->getResponsive()['device']['mobile'] ) ? 'true' : ''; ?>" />
                <span class="pl-2" style="padding-top:2px;">Mobile</span>
            </div>

            <div class="flex pl-6">
                <label for="switch_design_responsive_tablet" class="flex cursor-pointer">
                    <div class="relative">
                        <input
                                type="checkbox"
                                id="switch_design_responsive_tablet"
                                class="option_settings switch sr-only"
                                data-option="fab_design_responsive_tablet"
                            <?php echo ( $fab->getResponsive()['device']['tablet'] ) ? 'checked' : ''; ?>
                        >
                        <div class="block bg-gray-300 w-10 h-6 rounded-full"></div>
                        <div class="fab absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition"></div>
                    </div>
                </label>
                <input type="hidden" id="fab_design_responsive_tablet" name="fab_design_responsive[device][tablet]"
                       class="border border-gray-200 py-2 px-3 text-grey-darkest"
                       value="<?php echo ( $fab->getResponsive()['device']['tablet'] ) ? 'true' : ''; ?>" />
                <span class="pl-2" style="padding-top:2px;">Tablet</span>
            </div>

            <div class="flex pl-6">
                <label for="switch_design_responsive_desktop" class="flex cursor-pointer">
                    <div class="relative">
                        <input
                                type="checkbox"
                                id="switch_design_responsive_desktop"
                                class="option_settings switch sr-only"
                                data-option="fab_design_responsive_desktop"
                            <?php echo ( $fab->getResponsive()['device']['desktop'] ) ? 'checked' : ''; ?>
                        >
                        <div class="block bg-gray-300 w-10 h-6 rounded-full"></div>
                        <div class="fab absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition"></div>
                    </div>
                </label>
                <input type="hidden" id="fab_design_responsive_desktop" name="fab_design_responsive[device][desktop]"
                       class="border border-gray-200 py-2 px-3 text-grey-darkest"
                       value="<?php echo ( $fab->getResponsive()['device']['desktop'] ) ? 'true' : ''; ?>" />
                <span class="pl-2" style="padding-top:2px;">Desktop</span>
            </div>

        </div>
    </div><!--.grid-->

    <!--.grid, Field Shape-->
    <?php $shapeOption = ['shape']; ?>
    <?php if( in_array( $fab_design->template->name, $shapeOption ) ): ?>
    <div class="grid grid-cols-5 gap-4 py-4">
        <div class="font-medium text-gray-600 pt-2">
            <label for="field_option_design_template_shape">Shape</label>
        </div>
        <div class="col-span-4">
            <?php
                $shapeValue = isset( $fab_design->template->shape ) ? $fab_design->template->shape : 'none';
                $shapeValue = ( $fab->getTemplate()['shape'] ) ? $fab->getTemplate()['shape'] : $shapeValue;
            ?>
            <select id="field_option_design_template_shape"
                    name="fab_design_template[shape]"
                    class="field_option_design_template_shape select2"
                    data-selected="<?php echo esc_attr($shapeValue) ?>">
            </select>
            <div class="text-gray-400 mt-2">
                <em class="field-info">
                    Please refer to
                    <code><a href="https://bennettfeely.com/clippy/" target="_blank">Clippy</a></code>
                    to see the shape
                </em>
            </div>
        </div>
    </div>
    <!--.grid-->

    <!--.grid, Color-->
    <div class="grid grid-cols-5 gap-4 py-4">
        <div class="font-medium text-gray-600 pt-2">
            Color
        </div>
        <div class="col-span-4">
            <input type="text"
                   id="field_option_design_template_color"
                   class="colorpicker" name="fab_design_template[color]"
                   value="<?php echo ( $fab->getTemplate()['color'] ) ? esc_attr( $fab->getTemplate()['color'] ) : '' ?>">
        </div>
    </div>
    <!--.grid-->
    <?php endif; ?>
<?php endif; ?>

<div class="py-4 my-4 border-b border-gray-200">
    <span class="text-lg">Icon</span>
    <div class="text-gray-400">
        <em class="field-info">Icon configuration</em>
    </div>
</div>
<!--.grid, Field Icon Class-->
<div class="grid grid-cols-5 gap-4 py-4">
    <div class="font-medium text-gray-600 pt-2">
        Class
    </div>
    <div class="col-span-4">
        <input type="text" name="fab_design_icon_class"
               class="border border-gray-200 py-2 px-3 text-grey-darkest w-full " placeholder="fas fa-circle"
               value="<?php echo empty( esc_attr( $fab->getIconClass() ) ) ? '' : esc_attr( $fab->getIconClass() ); ?>" />
        <div class="text-gray-400 mt-2">
            <em class="field-info">
                Please refer to
                <code><a href="https://fontawesome.com/v5.15/icons/" target="_blank">Font Awesome</a></code>
                to see the icon class
            </em>
        </div>
    </div>
</div>
<!--.grid, Field Icon Class-->

<?php if ( $this->Helper->isPremiumPlan() ) : ?>
    <!--.grid, Color-->
    <div class="grid grid-cols-5 gap-4 py-4">
        <div class="font-medium text-gray-600 pt-2">
            Color
        </div>
        <div class="col-span-4">
            <input type="text"
                   id="field_option_design_template_icon_color"
                   class="colorpicker" name="fab_design_template[icon][color]"
                   value="<?php echo ( $fab->getTemplate()['icon']['color'] ) ? esc_attr( $fab->getTemplate()['icon']['color'] ) : '' ?>">
        </div>
    </div>
    <!--.grid-->
<?php endif; ?>

<?php if ( $this->Helper->isPremiumPlan() ) : ?>
    <div class="py-4 my-4 border-b border-gray-200">
        <span class="text-lg">Tooltip</span>
        <div class="text-gray-400">
            <em class="field-info">Tooltip configuration</em>
        </div>
    </div>

    <!--.grid, Color-->
    <div class="grid grid-cols-5 gap-4 py-4">
        <div class="font-medium text-gray-600 pt-2">
            Background Color
        </div>
        <div class="col-span-4">
            <input type="text"
                   id="field_option_design_template_tooltip_color"
                   class="colorpicker" name="fab_design_tooltip[color]"
                   value="<?php echo ( $fab->getTooltip()['color'] ) ? esc_attr( $fab->getTooltip()['color'] ) : '' ?>">
        </div>
    </div>
    <!--.grid-->

    <!--.grid, Color-->
    <div class="grid grid-cols-5 gap-4 py-4">
        <div class="font-medium text-gray-600 pt-2">
            Font Color
        </div>
        <div class="col-span-4">
            <input type="text"
                   id="field_option_design_template_tooltip_font_color"
                   class="colorpicker" name="fab_design_tooltip[font][color]"
                   value="<?php echo ( $fab->getTooltip()['font']['color'] ) ? esc_attr( $fab->getTooltip()['font']['color'] ) : '' ?>">
        </div>
    </div>
    <!--.grid-->
<?php endif; ?>
