<?php
/**
 * Metabox Location
 *
 * @package FAB
 */
?>

<!-- START: .fab-container  -->
<div class="fab-container metabox-location">
    <!-- metabox title -->
    <div class="font-medium text-gray-600 pt-2 col-span-5">
        Rules
        <div class="text-gray-400">
            <em class="field-info">
                Create a set of rules...
            </em>
        </div>
    </div>
    <div class="text-gray-400">
        <em class="field-info">
            Show If:
        </em>
    </div>

    <div id="element-rule-item" class="hidden">
        <div class="rule-item">
            <div class="flex my-2 gap-2">

                <!-- START: ORDER -->
                <div class="w-14">
                    <div class="inline-block py-2.5 mx-auto px-5 bg-white text-gray-500 border border-text-gray-300 rounded-md cursor-grab">
                        <em class="fas fa-bars"></em>
                    </div>
                </div>
                <!-- END: ORDER -->

                <!-- START: "fab_location_type[]"-->
                <div class="w-2/12">
                    <select name="fab_location_type[]" class="select2"></select>
                </div>
                <!-- END: "fab_location_type[]"-->

                <!-- START: "fab_location_operator[]"-->
                <div class="w-2/12">
                    <select name="fab_location_operator[]" class="select2"></select>
                </div>
                <!-- END: "fab_location_operator[]"-->

                <!-- START: "fab_location_value[]"-->
                <div class="w-4/12">
                    <select name="fab_location_value[]" class="w-full select2"></select>
                </div>
                <!-- END: "fab_location_value[]"-->

                <!-- START: "fab_location_logic[]"-->
                <div class="w-1/12">
                    <select name="fab_location_logic[]" class="w-full select2"></select>
                </div>
                <!-- END: "fab_location_logic[]"-->

                <!-- START: button-->
                <div class="w-1/12">
                    <button type="button" onclick="window.FAB_METABOX_LOCATION.remove_rule_item(this)"
                            class="remove-rule-item py-2.5 mx-auto px-5 bg-danger-600 text-white rounded-md cursor-pointer hover:shadow-md">
                        <em class="fas fa-minus"></em>
                    </button>
                    <button type="button" onclick="window.FAB_METABOX_LOCATION.add_rule_item()"
                            class="add-rule-item py-2.5 mx-auto px-5 bg-primary-600 text-white rounded-md cursor-pointer hover:shadow-md">
                        <em class="fas fa-plus"></em>
                    </button>
                </div>
                <!-- END: button-->
            </div>
        </div>
    </div>

    <div id="rules-locations"></div>

</div><!-- END: .fab-container  -->

<script type="text/javascript">
    jQuery(function($) {
        window.FAB_METABOX_LOCATION.init();
        jQuery( "#rules-locations" ).sortable();
    });
</script>