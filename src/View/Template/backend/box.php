<?php if($this->Page): ?>
    <h1><?= $this->Page->getPageTitle() ?></h1>
<?php endif; ?>

<div class="fab-tailwind">

    <div class="header <?= (isset($background)) ? $background : '' ?>">
        <?= (isset($nav)) ? $this->loadContent($nav) : '' ?>

        <ul class="nav-tab-wrapper <?= (isset($disableTab)) ? '' : 'nav-tab-general' ?>">
            <?php foreach($this->sections as $path => $section): ?>
                <?php extract($this->sectionLoopLogic($path, $section)); ?>
                <li class="nav-tab <?= ($active) ? 'nav-tab-active' : '' ?>" data-tab="section-<?= $slug ?>">
                    <?= $url ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="content">
        <?php foreach($this->sections as $path => $section): ?>
            <?php extract($this->sectionLoopLogic($path, $section)); ?>
            <div id="section-<?= $slug ?>" class="tab-content <?= ($active) ? 'current' : '' ?>">
                <?= $content ?>
            </div>
            <?php if($active): ?>
                <div stlye="display:none;">
                    <input type="hidden" name="activeSection" value="<?= $slug ?>">
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>