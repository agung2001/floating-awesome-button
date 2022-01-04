<?php
/**
 * Backend Page Setting - FAB Design
 */
$fab_design = ( isset( $options->fab_design ) ) ?
	$options->fab_design : $this->Plugin->getConfig()->default->fab_design;
?>

<h2 class="text-lg py-4 my-4 border-b border-gray-200">Button</h2>
<div class="grid grid-cols-5 gap-4 py-4">

    <div class="font-medium text-gray-600 pt-2">
        <label for="field_option_design_template_color">Color</label>
    </div>
    <div class="col-span-4">
        <input type="text" id="field_option_design_template_color"
               name="fab_design[template][color]"
               class="field_option_design_template_color colorpicker"
               value="<?php echo isset( $fab_design->template->color ) ? esc_attr( $fab_design->template->color ) : '#5b59ec'; ?>">
    </div>
</div>
<div class="grid grid-cols-5 gap-4 py-4">
    <div class="font-medium text-gray-600 pt-2">
        Tooltip
    </div>
    <div class="col-span-4">
        <div class="flex mb-4">
            <label for="switch_option_design_tooltip" class="flex cursor-pointer">
                <div class="relative">
                    <input
                            type="checkbox"
                            id="switch_option_design_tooltip"
                            class="option_settings switch sr-only"
                            data-option="field_option_design_tooltip_enable"
                        <?php echo ( esc_attr( $fab_design->tooltip->enable ) ) ? 'checked' : ''; ?>
                    >
                    <div class="block bg-gray-300 w-10 h-6 rounded-full"></div>
                    <div class="fab absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition"></div>
                </div>
            </label>
            <input type="hidden" name="fab_design[tooltip][enable]" id="field_option_design_tooltip_enable" value="<?php echo esc_attr( $fab_design->tooltip->enable ); ?>">
            <span class="pl-2" style="padding-top:2px;">Enable/Disable</span>
        </div>
    </div>
</div>

<h2 class="text-lg py-4 my-4 border-b border-gray-200">Icon</h2>
<div class="grid grid-cols-5 gap-4 py-4">
    <div class="font-medium text-gray-600 pt-2">
        <label for="field_option_design_template_icon">Class</label>
    </div>
    <div class="col-span-4">
        <input type="text" id="field_option_design_template_icon"
               name="fab_design[template][icons][class]"
               class="field_option_design_template_icon border border-gray-200 py-2 px-3 text-grey-darkest w-full"
               value="<?php echo isset( $fab_design->template->icons->class ) ? esc_attr( $fab_design->template->icons->class ) : 'fas fa-ellipsis-h'; ?>">
        <div class="text-gray-400 mt-2">
            <em class="field-info">
                Please refer to
                <code><a href="https://fontawesome.com/v5.15/icons/" target="_blank">Font Awesome</a></code>
                to see the icon class
            </em>
        </div>
    </div>
</div>
<div class="grid grid-cols-5 gap-4 py-4">
    <div class="font-medium text-gray-600 pt-2">
        <label for="field_option_design_template_color">Color</label>
    </div>
    <div class="col-span-4">
        <input type="text" id="field_option_design_template_color"
               name="fab_design[template][icons][color]"
               class="field_option_design_template_color colorpicker"
               value="<?php echo isset( $fab_design->template->icons->color ) ? esc_attr( $fab_design->template->icons->color ) : '#fff'; ?>">
    </div>
</div>

<!--Start: Layout-->
<h2 class="text-lg py-4 my-4 border-b border-gray-200">Layout</h2>
<div class="grid grid-cols-5 gap-4 py-4">
	<div class="font-medium text-gray-600 pt-2">
		<label for="field_option_design_layout_position">Position</label>
	</div>
	<div class="col-span-4">
		<select id="field_option_design_layout_position"
				name="fab_design[layout][position]"
				class="field_option_design_layout_position select2"
				data-selected="<?php echo isset( $fab_design->layout->position ) ? esc_attr( $fab_design->layout->position ) : ''; ?>">
		</select>
	</div>
</div>
<!--End: Layout-->

<h2 class="text-lg py-4 my-4 border-b border-gray-200">Template</h2>
<!--Start: Template-->
    <div class="grid grid-cols-5 gap-4 py-4">
        <div class="font-medium text-gray-600 pt-2">
            <label for="field_option_design_template_name">Name</label>
        </div>
        <div class="col-span-4">
            <select id="field_option_design_template_name"
                    name="fab_design[template][name]"
                    class="field_option_design_template_name select2"
                    data-selected="<?php echo isset( $fab_design->template->name ) ? esc_attr( $fab_design->template->name ) : 'classic'; ?>">
            </select>
        </div>
    </div>

    <div class="grid grid-cols-5 gap-4 py-4">
        <div class="font-medium text-gray-600 pt-2">
            <label for="field_option_design_template_shape">Shape</label>
        </div>
        <div class="col-span-4">
            <select id="field_option_design_template_shape"
                    name="fab_design[template][shape]"
                    class="field_option_design_template_shape select2"
                    data-selected="<?php echo isset( $fab_design->template->shape ) ? esc_attr( $fab_design->template->shape ) : 'none'; ?>">
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
<!--End: Template-->
