<?php
/**
 * Metabox Design
 *
 * @package FAB
 */

use Fab\View;

?>

<!-- START: ".fab-container" -->
<div class="fab-container metabox-design">

    <?php
        $view = new View( $this->Plugin );
        $view->setTemplate( 'backend.optiontab' );
        $view->setSections(
            array(
                'Backend.Metabox.tab-design.button' => array(
                    'name'   => 'Button',
                    'active' => true,
                    'target' => 'design-button',
                ),
                'Backend.Metabox.tab-design.modal' => array(
                    'name'   => 'Modal',
                    'active' => false,
                    'target'   => 'design-modal',
                ),
            )
        );
        $view->setData(array(
            'fab' => $fab,
            'options' => $options,
            'optionTab' => 'optionTabDesign',
        ));
        $view->setOptions( array( 'shortcode' => false ) );
        $view->build();
    ?>

</div>
<!-- END: ".fab-container" -->

<script type="text/javascript">
    jQuery(function($) {
        window.FAB_METABOX_DESIGN.init();
    });
</script>