<?php
	/** Grab Data */
	$data = $this->Plugin->getModels()['Fab'];
	$data = $data->get_lists_of_fab();
?>
<input type="hidden" name="fab_order" value="<?php echo wp_json_encode( $data['order'] ); ?>">
<div class="grid grid-cols-5 gap-4 py-6">
    <div class="font-medium text-gray-600 pt-2">
        Button Order
    </div>
    <div class="col-span-4">

        <div class="flex flex-wrap overflow-hidden">

            <?php if($data['items']){ ?>
                <div id="fab-order" class="w-full">
                    <?php foreach ( $data['items'] as $fab ) : ?>
                        <div data-id="<?php echo esc_attr( $fab->getID() ); ?>"
                            class="bg-white fab-item shadow-sm hover:shadow-md border border-gray-200 rounded-lg px-6 py-4 mb-2 cursor-grab">
                            <div class="inline-block">
                                <span><em class="fas fa-bars text-gray-500 mr-2"></em></span>
                                <em class="<?php echo esc_attr( $fab->getIconClass() ); ?> text-primary-600 mr-2"></em>
                                <?php echo esc_attr( $fab->getTitle() ); ?>
                            </div>
                            <div class="inline-block float-right">
                                <?php $url = get_edit_post_link($fab->getID()) ?>
                                <a href="<?php echo esc_url($url); ?>" class="text-gray-500">
                                    <em class="fas fa-link"></em>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php } else { ?>
                <div class="w-4/12 text-center">
                    <a href="<?php echo esc_url( admin_url() ) ?>/post-new.php?post_type=fab" class="my-3 py-3 block w-full bg-primary-600 text-white text-center rounded-md">
                        <em class="fas fa-plus"></em>
                        Create your first awesome button
                    </a>
                </div>
            <?php } ?>
        </div>

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
