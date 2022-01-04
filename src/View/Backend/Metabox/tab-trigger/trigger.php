<!--.grid, Trigger-->
<div class="grid grid-cols-5 gap-4 py-4">
    <div class="font-medium text-gray-600 pt-2">
        Type
    </div>
    <div class="col-span-4">
        <select id="fab_trigger_type" name="fab_trigger[type]" class="select2" data-selected="<?php echo isset($fab->getTrigger()['type']) ? esc_attr( $fab->getTrigger()['type'] ) : 'none'; ?>"></select>
    </div>
</div>
<!--.grid-->

<!--.grid, Trigger-->
<div class="grid grid-cols-5 gap-4 py-4">
    <div class="font-medium text-gray-600 pt-2">
        Delay
    </div>
    <div class="col-span-4">
        <input id="fab_trigger_delay" name="fab_trigger[delay]"
               class="border border-gray-200 py-2 px-3 text-grey-darkest w-full"
               value="<?php echo isset($fab->getTrigger()['delay']) ? esc_attr( $fab->getTrigger()['delay'] ) : ''; ?>"
               placeholder="1000ms">
    </div>
</div>
<!--.grid-->