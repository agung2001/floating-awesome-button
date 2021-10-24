<script type="text/javascript">
    window.fabPlugin = {
        name: '<?= FAB_NAME ?>',
        version: '<?= FAB_VERSION ?>',
        screen: <?= json_encode($screen) ?>,
        path: <?= json_encode($path) ?>,
        options: {
            animation_tab: '<?= $options->fab_animation_tab ?>',
            animation_content: '<?= $options->fab_animation_content ?>',
            animation_active: '<?= $options->fab_animation_active ?>',
            animation_inactive: '<?= $options->fab_animation_inactive ?>',
        }
    };
</script>