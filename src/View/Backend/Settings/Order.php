<?php 

$Fab = $this->Plugin->getModels()['Fab'];
$setting_type = $Fab->getSettingType();
$fab_order = $Fab->get_fab_to_order();
$ids = $fab_order['ids'];
$fab_items = $fab_order['items'];
?>
<input type="hidden" name="fab_order" value="<?= json_encode($ids) ?>">
<div class="flex flex-wrap overflow-hidden">
    <div id="fab-order" class="w-full">
        <?php foreach($fab_items as $fab_item): ?>
            <div data-id="<?= $fab_item['id']; ?>"
                class="bg-white fab-item shadow-md border border-gray-200 rounded-lg px-6 py-4 mb-2 cursor-grab">
                <i class="<?= $fab_item['icon_class'] ?> text-primary-600 mr-2"></i>
                <?= get_the_title($fab_item['id'] ) ?> [<?= $setting_type[$fab_item['type']] ?>]
            </div>
            <?php endforeach; ?>
            
    </div>
</div>
<script>
    jQuery(document).ready(function ($) {
        $('#fab-order').sortable({
            stop: (e, ui)=>{
                let orders = $.map($(this).find('.fab-item'), (el)=>{
                    return $(el).data('id');
                });
                
                $('input[name="fab_order"]').val(JSON.stringify(orders));
            }
        });
    });
</script>