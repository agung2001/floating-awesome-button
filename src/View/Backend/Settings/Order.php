<?php
	/** Grab Data */
	$data = $this->Plugin->getModels()['Fab'];
	$data = $data->get_lists_of_fab();
?>
<input type="hidden" name="fab_order" value="<?php echo wp_json_encode( $data['order'] ); ?>">
<div class="flex flex-wrap overflow-hidden">
	<div id="fab-order" class="w-full">
		<?php foreach ( $data['items'] as $fab ) : ?>
			<div data-id="<?php echo esc_attr( $fab->getID() ); ?>"
				class="bg-white fab-item shadow-md border border-gray-200 rounded-lg px-6 py-4 mb-2 cursor-grab">
				<em class="<?php echo esc_attr( $fab->getIconClass() ); ?> text-primary-600 mr-2"></em>
				<?php echo esc_attr( $fab->getTitle() ); ?> [<?php echo esc_attr( $fab->getType() ); ?>]
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
