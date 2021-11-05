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
						data-option="field_option_animation_enable"
						<?php echo ( esc_attr( $options->fab_animation->enable ) ) ? 'checked' : ''; ?>
					>
					<div class="block bg-gray-300 w-10 h-6 rounded-full"></div>
					<div class="fab absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition"></div>
				</div>
			</label>
			<input type="hidden" name="fab_animation[enable]" id="field_option_animation_enable" value="<?php echo esc_attr( $options->fab_animation->enable ); ?>">
		</div>
		<div class="text-gray-400">
			<em class="field-info">
				You can turn on/off the animation by switching the toggle button.
				To see animation reference you can go to
				<code><a href="https://daneden.github.io/animate.css/" target="_blank">Animate.css</a></code>.
			</em>
		</div>
	</div>
</div>

<?php if ( ! $this->Plugin->getConfig()->production ) : ?>
	<div class="grid grid-cols-5 gap-4 py-4">
		<div class="font-medium text-gray-600 pt-2">
			<label for="field_option_animation_logo">Logo Animation</label>
		</div>
		<div class="col-span-4">
			<select id="field_option_animation_logo"
                    name="fab_animation[elements][logo]"
					class="field_option_animation_element select2"
					data-option="logo"
					data-selected="<?php echo esc_attr( $options->fab_animation->elements->logo ); ?>">
			</select>
		</div>
	</div>

	<div class="grid grid-cols-5 gap-4 py-4">
		<div class="font-medium text-gray-600 pt-2">
			<label for="field_option_animation_tab">Section Tab</label>
		</div>
		<div class="col-span-4">
			<select id="field_option_animation_tab"
                    name="fab_animation[elements][tab]"
					class="field_option_animation_element select2"
					data-option="tab"
					data-selected="<?php echo esc_attr( $options->fab_animation->elements->tab ); ?>">>
			</select>
		</div>
	</div>

	<div class="grid grid-cols-5 gap-4 py-4">
		<div class="font-medium text-gray-600 pt-2">
			<label for="field_option_animation_content">Section Content</label>
		</div>
		<div class="col-span-4">
			<select id="field_option_animation_content"
                    name="fab_animation[elements][content]"
					class="field_option_animation_element select2"
					data-option="content"
					data-selected="<?php echo esc_attr( $options->fab_animation->elements->content ); ?>">>
			</select>
		</div>
	</div>
<?php endif; ?>
<?php if ( $this->Helper->isPremiumPlan() ) : ?>
	<div class="grid grid-cols-5 gap-4 py-4">
		<div class="font-medium text-gray-600 pt-2">
			<label for="field_option_animation_active">FAB Animation Active</label>
		</div>
		<div class="col-span-4">
			<select id="field_option_animation_active"
                    name="fab_animation[elements][fab_active]"
					class="field_option_animation_element select2"
					data-option="fab_active"
					data-selected="<?php echo esc_attr( $options->fab_animation->elements->fab_active ); ?>">>
			</select>
		</div>
	</div>

	<div class="grid grid-cols-5 gap-4 py-4">
		<div class="font-medium text-gray-600 pt-2">
			<label for="field_option_animation_inactive">FAB Animation Inactive</label>
		</div>
		<div class="col-span-4">
			<select id="field_option_animation_inactive"
                    name="fab_animation[elements][fab_inactive]"
					class="field_option_animation_element select2"
					data-option="fab_inactive"
					data-selected="<?php echo esc_attr( $options->fab_animation->elements->fab_inactive ); ?>">>
			</select>
		</div>
	</div>
<?php endif; ?>