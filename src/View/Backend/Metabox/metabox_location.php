<!-- START: .fab-container  -->
<div class="fab-container metabox-location">
    <!-- metabox title -->
    <div class="font-medium text-gray-600 pt-2 col-span-5">
        Rules
        <div class="text-gray-400">
            <i class="field-info">
                Create a set of rules...
            </i>
        </div>
    </div>
    <div class="text-gray-400">
        <i class="field-info">
            Show If:
        </i>
    </div>

    <!-- START: .rule-group  -->
    <?php foreach($fab_location as $fab_loc): ?>
    <div class="rule-group">
        <div class="rule-item my-2">
            <div class="grid grid-cols-5 gap-2">
                <!-- START: "fab_setting_field[]"-->
                <div>
                    <select name="fab_setting_field[]"  class="select2">
                        <option value="0">--choose--</option>
                        <?php foreach($when_data as $option): ?>
                        <option <?= $option['id'] == $fab_loc['type'] ? 'selected="selected"':'' ?>
                            value="<?= $option['id'] ?>">
                            <?= $option['label'] ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <!-- END: "fab_setting_field[]"-->

                <!-- START: "fab_setting_operator[]"-->
                <div class="">
                    <select name="fab_setting_operator[]"  class="select2">
                        <option <?= '==' == $fab_loc['operator'] ? 'selected="selected"':'' ?> value="=="
                            selected="selected" data-i="0">is equal to</option>
                        <option <?= '!=' == $fab_loc['operator'] ? 'selected="selected"':'' ?> value="!=">is not
                            equal to</option>
                    </select>
                </div>
                <!-- END: "fab_setting_operator[]"-->

                <!-- START: "fab_setting_comparator[]"-->
                <div class="col-span-2">
                    <select name="fab_setting_comparator[]"  class="select2">
                        <option value="0">--choose--</option>
                        <?php foreach($fab_loc['compares'] as $optKey=>$optLabel): ?>
                        <option <?= $optKey == $fab_loc['value'] ? 'selected="selected"':'' ?> value="<?= $optKey ?>">
                            <?= $optLabel ?></option>
                        <?php endforeach; ?>

                    </select>
                </div>
                <!-- END: "fab_setting_comparator[]"-->

                <!-- START: button-->
                <div>
                    <button type="button" onclick="window.fabPlugin.remove_rule_item(this)"
                        class="py-3 mx-auto px-5 bg-white text-gray-500 border border-gray-300 rounded-md cursor-pointer">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" onclick="window.fabPlugin.add_rule_group(this)"
                        class="py-3 mx-auto px-5 bg-white text-gray-500 border border-gray-300 rounded-md cursor-pointer">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                <!-- END: button-->
            </div>
        </div>
    </div><!-- END: .rule-group  -->
    <?php endforeach; ?>
</div><!-- END: .fab-container  -->