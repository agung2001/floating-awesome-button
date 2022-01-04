<!--.grid, Trigger-->
<div class="grid grid-cols-5 gap-4 py-4">
    <div class="font-medium text-gray-600 pt-2">
        Expiration (Days)
    </div>
    <div class="col-span-4">
        <input id="fab_trigger_expiration" name="fab_trigger[cookie][expiration]"
               class="border border-gray-200 py-2 px-3 text-grey-darkest w-full"
               value="<?php echo isset($fab->getTrigger()['cookie']['expiration']) ? esc_attr( $fab->getTrigger()['cookie']['expiration'] ) : ''; ?>"
               placeholder="30">
    </div>
</div>
<!--.grid-->