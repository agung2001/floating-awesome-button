<?php
/** Variable Revalidation */
$buttonAnimation = ( isset( $options->fab_animation->elements->fab ) ) ? $options->fab_animation->elements->fab : $default->fab_animation->elements->fab;
$buttonColor     = ( isset( $options->fab_design->template->color ) ) ? $options->fab_design->template->color : $default->fab_design->template->color;
$buttonIcon      = ( isset( $options->fab_design->template->icons->class ) ) ? $options->fab_design->template->icons->class : $default->template->icons->class;
$buttonIconColor = ( isset( $options->fab_design->template->icons->color ) ) ? $options->fab_design->template->icons->color : $default->template->icons->color;
$buttonPosition  = ( isset( $options->fab_design->layout->position ) ) ? $options->fab_design->layout->position : $default->fab_design->layout->position;
$buttonShape     = ( isset( $options->fab_design->template->shape ) ) ? $options->fab_design->template->shape : $default->fab_design->template->shape;
$buttonTemplate  = ( isset( $options->fab_design->template->name ) ) ? $options->fab_design->template->name : $default->fab_design->template->name;
$buttonTooltipEnable = ( isset( $options->fab_design->tooltip->enable ) ) ? $options->fab_design->tooltip->enable : $default->fab_design->tooltip->enable;
?>
<!--float button-->
<div class="fab-container" style="display:none;">
    <div class="
		fab-floating-button
		fab-template-<?php echo esc_attr( $buttonTemplate ); ?> fab-template-shape-container-<?php echo esc_attr( $buttonShape ); ?>
		fab-position-<?php echo esc_attr( $buttonPosition ); ?>
		<?php echo ( $buttonAnimation !== 'ripple' ) ? sprintf( 'animate__animated animate__%s', esc_attr( $buttonAnimation ) ) : ''; ?>">
        <div class="fac animate__animated">
            <?php foreach ( $fab_to_display as $fab_item ) : ?>
                <?php
                /** Responsive */
                $responsiveClass  = ( $fab_item->getResponsive()['device']['mobile'] ) ? 'block ' : 'hidden ';
                $responsiveClass .= ( $fab_item->getResponsive()['device']['tablet'] ) ? 'sm:block ' : 'sm:hidden ';
                $responsiveClass .= ( $fab_item->getResponsive()['device']['desktop'] ) ? 'lg:block ' : 'lg:hidden ';
                ?>
                <a id="fab-link-<?php echo esc_attr( $fab_item->getID() ); ?>"
                    <?php
                    /** Data (ID) */
                    echo sprintf( ' data-id="%s" ', esc_attr( $fab_item->getID() ) );

                    /** Data (Link Behavior) */
                    echo ( 'link' === esc_attr( $fab_item->getType() ) && esc_attr( $fab_item->getLinkBehavior() ) ) ?
                        ' target="_blank"' : '';

                    /** Href */
                    echo ( 'link' === esc_attr( $fab_item->getType() ) ) ?
                        sprintf( ' href="%s"', esc_url( $fab_item->getLink() ) ) : '';

                    /** Class - Shape */
                    $shapeClass = ($fab_item->getTemplate()['shape']!='none') ? $fab_item->getTemplate()['shape'] : $buttonShape;
                    $shapeClass = sprintf('fab-template-shape-%s', $shapeClass);
                    ?>
                   class="fab-links cursor-pointer <?php echo esc_attr( $responsiveClass ); ?> <?php echo esc_attr( $shapeClass ); ?>"
                >
                    <div class="bg-shape"></div>
                    <?php if($buttonTooltipEnable): ?> <span class="fab-tooltip"><?php echo esc_attr( get_the_title( $fab_item->getID() ) ); ?></span> <?php endif;?>
                    <em
                            title="<?php echo esc_attr( get_the_title( $fab_item->getID() ) ); ?>"
                            class="<?php echo empty( esc_attr( $fab_item->getIconClass() ) ) ? 'fas fa-circle' : esc_attr( $fab_item->getIconClass() ); ?>"
                    >
                    </em>
                </a>
                <style>
                    <?php
                        /** Button Color */
                        if($fab_item->getTemplate()['color']){
                            $styles = sprintf(
                                '#fab-link-%s .bg-shape { background: %s; }',
                                $fab_item->getID(), $fab_item->getTemplate()['color']);
                            echo esc_attr($styles);
                        }
                        /** Icon Color */
                        if($fab_item->getTemplate()['icon']['color']){
                            $styles = sprintf(
                                '#fab-link-%s em { color: %s; }',
                                $fab_item->getID(), $fab_item->getTemplate()['icon']['color']);
                            echo esc_attr($styles);
                        }

                        /** Tooltip */
                        if($buttonTooltipEnable){
                            $tooltipColor = ( $fab_item->getTooltip()['color'] ) ? $fab_item->getTooltip()['color'] : $buttonColor;
                            $tooltipFontColor = ( $fab_item->getTooltip()['font']['color'] ) ? $fab_item->getTooltip()['font']['color'] : $buttonIconColor;
                            $styles = sprintf('#fab-link-%s .fab-tooltip { background: %s; border-color: %s; color: %s; } ',
                                $fab_item->getID(), $tooltipColor, $tooltipColor, $tooltipFontColor );
                            if($buttonPosition=='left'){
                                $styles .= sprintf(
                                    '#fab-link-%s .fab-tooltip::after { border-color: transparent %s transparent transparent; } ',
                                    $fab_item->getID(), $tooltipColor);
                            } else {
                                $styles .= sprintf(
                                    '#fab-link-%s .fab-tooltip::after { border-color: transparent transparent transparent %s; } ',
                                    $fab_item->getID(), $tooltipColor);
                            }
                            echo esc_attr($styles);
                        }
                    ?>
                </style>
            <?php endforeach; ?>
        </div>
        <input type="checkbox" id="fab-checkbox" />
        <div class="fab fab-template-shape-<?php echo esc_attr( $buttonShape ); ?>">
            <?php if ( $buttonAnimation === 'ripple' ) : ?>
                <div class="animation-ripple" style="background: <?php echo esc_attr( $buttonColor ); ?>;"></div>
                <div class="animation-ripple" style="background: <?php echo esc_attr( $buttonColor ); ?>; animation-delay: 0.6s;"></div>
            <?php endif; ?>
            <em class="<?php echo esc_attr( $buttonIcon ); ?>"></em>
            <div class="bg-shape"></div>
        </div>
        <style>
            <?php
                /** FAB Button Styling */
                $styles = sprintf( 'div.fab { background: %s; } ', $buttonColor ); // Button Color.
                $styles .= sprintf( 'div.fab em { color: %s; } ', $buttonIconColor ); // Button Icon Color.
                echo esc_attr( $styles );

                /** FAB Button Styling Custom Shape */
                $clipShape = ['bevel', 'circle', 'message', 'octagon', 'pentagon', 'rebbet', 'rhombus', 'square', 'star', 'triangle'];
                if(in_array($buttonShape, $clipShape)){
                    $styles = sprintf( 'background: %s !important;  ', $buttonColor);
                    $styles = sprintf('div.fab .bg-shape{ %s }', $styles);
                    echo esc_attr($styles);
                }
            ?>
        </style>
    </div>
</div><!--.fab-container-->