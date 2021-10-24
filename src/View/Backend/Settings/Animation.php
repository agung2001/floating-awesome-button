<div class="grid grid-cols-5 gap-4 py-6">
    <div class="font-medium text-gray-600 pt-2">
        Enable Option
    </div>
    <div class="col-span-4">
        <div class="flex mb-4">
            <label for="switch_option_animation" class="flex cursor-pointer">
                <div class="relative">
                    <input
                        type="checkbox"
                        id="switch_option_animation"
                        class="option_settings switch sr-only"
                        data-option="field_option_animation"
                        <?= ($options->fab_animation) ? 'checked' : '' ?>
                    >
                    <div class="block bg-gray-300 w-10 h-6 rounded-full"></div>
                    <div class="fab absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition"></div>
                </div>
            </label>
            <input type="hidden" id="field_option_animation" name="field_option_animation" value="<?= $options->fab_animation ?>">
        </div>
        <div class="text-gray-400">
            <i class="field-info">
                You can turn on/off the animation by switching the toggle button.
                To see animation reference you can go to
                <code><a href="https://daneden.github.io/animate.css/" target="_blank">Animate.css</a></code>.
            </i>
        </div>
    </div>
</div>

<?php if(!$this->Plugin->getConfig()->production): ?>
    <div class="grid grid-cols-5 gap-4 py-4">
        <div class="font-medium text-gray-600 pt-2">
            Logo Animation
        </div>
        <div class="col-span-4">
            <select name="field_option_animation_logo" id="field_option_animation_logo" class="select2">
                <?= $this->loadContent('Element.option_animations', [
                    'value' => $this->esc('attr',$options->fab_animation_logo)
                ]) ?>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-5 gap-4 py-4">
        <div class="font-medium text-gray-600 pt-2">
            Section Tab
        </div>
        <div class="col-span-4">
            <select name="field_option_animation_tab" id="field_option_animation_tab" class="select2">
                <?= $this->loadContent('Element.option_animations', [
                    'value' =>  $this->esc('attr', $options->fab_animation_tab)
                ]) ?>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-5 gap-4 py-4">
        <div class="font-medium text-gray-600 pt-2">
            Section Content
        </div>
        <div class="col-span-4">
            <select name="field_option_animation_content" id="field_option_animation_content" class="select2">
                <?= $this->loadContent('Element.option_animations', [
                    'value' => $this->esc('attr',$options->fab_animation_content)
                ]) ?>
            </select>
        </div>
    </div>
<?php endif; ?>
<?php if($this->Helper->isPremiumPlan()): ?>
    <div class="grid grid-cols-5 gap-4 py-4">
        <div class="font-medium text-gray-600 pt-2">
            FAB Animation Active
        </div>
        <div class="col-span-4">
            <select name="field_option_animation_active" id="field_option_animation_active" class="select2">
                <?= $this->loadContent('Element.option_animations', [
                    'value' => $this->esc('attr',$options->fab_animation_active)
                ]) ?>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-5 gap-4 py-4">
        <div class="font-medium text-gray-600 pt-2">
            FAB Animation Inactive
        </div>
        <div class="col-span-4">
            <select name="field_option_animation_inactive" id="field_option_animation_inactive" class="select2">
                <?= $this->loadContent('Element.option_animations', [
                    'value' => $this->esc('attr',$options->fab_animation_inactive)
                ]) ?>
            </select>
        </div>
    </div>
<?php endif; ?>
