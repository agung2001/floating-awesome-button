<?php 

/** options for select[name=fab_setting_type] */
$setting_types = $this->Plugin->getModels()['Fab']->getSettingType();
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
                <?php foreach($setting_types as $key=>$label): ?>
                <option value="<?= $key ?>" <?= ($key == $fab_setting_type) ? 'selected="selected"' : '' ?>>
                    <?= $label ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div><!--.grid-->
    
    <!--.grid, Field Link-->
    <div class="grid grid-cols-5 gap-4 py-4 link-info" style="<?= 'link' != $fab_setting_type ? 'display:none':'' ?>">
        <div class="font-medium text-gray-600 pt-2">
            Link Address
        </div>
        <div class="col-span-4">
            <input type="url" name="fab_setting_link" <?= 'link' == $fab_setting_type ?  'required="required"' : '' ?>
                placeholder="http://example.com"
                class="border border-gray-200 py-2 px-3 text-grey-darkest w-full" 
                value="<?= empty($fab_setting_link) ? '' : $fab_setting_link  ?>" />
                
        </div>
    </div><!--.grid-->


    <!--.grid, Field Link Behaviour-->
    <div class="grid grid-cols-5 gap-4 py-4 link-info" style="<?= 'link' != $fab_setting_type ? 'display:none':'' ?>">
        <div class="font-medium text-gray-600 pt-2">
            
        </div>
        <div class="col-span-4">
            <label>
            <input type="checkbox" name="fab_setting_open_in"
                class="border border-gray-200 py-2 px-3 text-grey-darkest" 
                <?= empty($fab_setting_open_in) ? '' :'checked="checked"'  ?>
                value="1" /> Open In new Window
            </label>
        </div>
    </div><!--.grid-->

    
    <!--.grid, Function Key-->
    <?php if($this->Helper->isPremiumPlan()): ?>
        <div class="grid grid-cols-5 gap-4 py-4">
            <div class="font-medium text-gray-600 pt-2">
                Function Key
            </div>
            <div class="col-span-4">
                <select name="fab_setting_key" class="select2" placeholder="Function Key">
                    <option value="">--choose--</option>
                    <?php for($i=1;$i<=12;$i++): ?>
                    <option value="f<?= $i ?>" <?= ("f".$i == $fab_setting_key) ? 'selected="selected"' : '' ?>>
                        F<?= $i ?>
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
                value="<?= empty($fab_setting_icon_class) ?'':$fab_setting_icon_class  ?>" />
            <i class="field-info block mt-2">
                Please refer to
                <code><a href="https://fontawesome.com/v5.15/icons/" target="_blank">Font Awesome</a></code>
                to see the icon class
            </i>
        </div>
    </div><!--.grid-->
</div>
<!-- END: ".fab-container" -->