<?php
if( !is_admin() && $fab_to_display ): 
    $count = count($fab_to_display);
    $multipier = $count >= 3 ? 45: 30;
    $css_height = ($count * $multipier);
?>
<!--float button-->
<div class="fab-container">
    <div class="fab-floating-button">
        <input type="checkbox" />
        <div class="ripple"></div>
        <div class="ripple" style="animation-delay: 0.6s;"></div>
        <div class="fab">
            <i class="fas fa-ellipsis-h"></i>
        </div>
        <div class="fac animate__animated" style="height:<?= 30+$css_height ?>px;top:<?= -40-$css_height ?>px">
            <?php foreach($fab_to_display as $fab_item): ?>
            <a id="fab-link-<?= $fab_item['id'] ?>"
                data-id="<?= $fab_item['id'] ?>"
                data-type="<?= $fab_item['type'] ?>"
                <?= empty($fab_item['hotkey']) ? '' : ' data-hotkey="'.$fab_item['hotkey'].'" ' ?>
                <?= ('link' != $fab_item['type']) ? 'data-modal="fab-modal-'.$fab_item['id'].'"':'' ?>
                <?= ('link' == $fab_item['type'] && $fab_item['new_window']) ? 'target="_fab_window_'.$fab_item['id'].'"':'' ?>
                <?php if( 'link' == $fab_item['type']):?> 
                    href="<?=  $fab_item['link'] ?>"
                    class="fab-links cursor-pointer"
                <?php else: ?>
                    class="fab-links j-links cursor-pointer"
                <?php endif; ?>
                >
                <i title="<?= get_the_title( $fab_item['id'] ); ?>" class="<?= empty($fab_item['icon_class']) ? 'fas fa-circle' : $fab_item['icon_class'] ?>"></i>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</div><!--.fab-container-->

<!--Modal-->
<?php foreach($fab_to_display as $fab_item): ?>
    <?php if( 'link' == $fab_item['type']) continue; ?>
    <div class="fab-container">
        <div
            id="fab-modal-<?= $fab_item['id'] ?>"
            class="hidden modal" data-title="<?= get_the_title( $fab_item['id'] ); ?>"
            data-icon="<?= empty($fab_item['icon_class']) ? 'fas fa-circle' : $fab_item['icon_class'] ?>">
                <div class="w-full overflow-hidden">
                    <?php if('modal' == $fab_item['type']): ?>
                        <?= do_shortcode(get_post_field('post_content', $fab_item['id'])); ?>
                    <?php elseif('widget' == $fab_item['type']): ?>
                        <?php dynamic_sidebar( 'fab-widget-'.$fab_item['slug'] ); ?>
                    <?php elseif('widget_content' == $fab_item['type']): ?>
                        <?= do_shortcode(get_post_field('post_content', $fab_item['id'])); ?>
                        <?php dynamic_sidebar( 'fab-widget-'.$fab_item['slug'] ); ?>
                    <?php endif; ?>
                </div>
        </div>
    </div>
<?php endforeach; ?>
<?php endif; ?>