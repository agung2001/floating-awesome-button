<div class="wrap">

    <?php if($this->Page): ?>
        <h1><?php echo  $this->Page->getPageTitle() ?></h1>
    <?php endif; ?>

    <div class="fab-container">
        <div class="header <?php echo  (isset($background)) ? $background : '' ?>">
            <?php echo  (isset($nav)) ? $this->loadContent($nav) : '' ?>

            <ul class="nav-tab-wrapper <?php echo  (isset($disableTab)) ? '' : 'nav-tab-jconfirm' ?>">
                <?php foreach($this->sections as $path => $section): ?>
                    <?php extract($this->sectionLoopLogic($path, $section)); ?>
                    <li class="nav-tab <?php echo  ($active) ? 'nav-tab-active' : '' ?>" data-tab="section-<?php echo  $slug ?>">
                        <?php echo  $url ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="content">
            <?php foreach($this->sections as $path => $section): ?>
                <?php extract($this->sectionLoopLogic($path, $section)); ?>
                <div id="section-<?php echo  $slug ?>" class="tab-content fab-sections <?php echo  ($active) ? 'current' : '' ?>">
                    <?php echo  $content ?>
                </div>
                <?php if($active): ?>
                    <div stlye="display:none;">
                        <input type="hidden" name="activeSection" value="<?php echo  $slug ?>">
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>

</div>

