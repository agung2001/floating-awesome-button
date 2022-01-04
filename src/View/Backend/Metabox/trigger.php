<?php
/**
 * Metabox Trigger
 *
 * @package FAB
 */

use Fab\View;
?>

<!-- START: ".fab-container" -->
<div class="fab-container metabox-triggers">
    <?php
        $view = new View( $this->Plugin );
        $view->setTemplate( 'backend.optiontab' );
        $view->setSections(
            array(
                'Backend.Metabox.tab-trigger.trigger' => array(
                    'name'   => 'Trigger',
                    'active' => true,
                    'target' => 'trigger-trigger',
                ),
                'Backend.Metabox.tab-trigger.cookies' => array(
                    'name'   => 'Cookies',
                    'target'   => 'trigger-cookies',
                ),
            )
        );
        $view->setData(array(
            'fab' => $fab,
            'optionTab' => 'optionTabTrigger',
        ));
        $view->setOptions( array( 'shortcode' => false ) );
        $view->build();
    ?>
</div>
<!-- END: ".fab-container" -->

<script type="text/javascript">
    jQuery(function($) {
        window.FAB_METABOX_TRIGGER.init();
    });
</script>
