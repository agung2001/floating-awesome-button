<?php foreach($this->sections as $path => $options): ?>
    <?= $this->loadContent($path) ?>
<?php endforeach; ?>
