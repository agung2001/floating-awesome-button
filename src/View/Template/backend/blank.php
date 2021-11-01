<?php foreach($this->sections as $path => $options): ?>
    <?php echo  $this->loadContent($path) ?>
<?php endforeach; ?>
