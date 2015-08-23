<?php #App::import( 'Element', 'Comments/blocks.ctp'); ?>
<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Forums'), ['controller' => 'Forums', 'action' => 'index']) ?></li>
    </ul>
</div>

<!--<?= $this->element('Comments/add/form'); ?>-->

<div class="comments form large-10 medium-9 columns">
    <?= $this->Form->create($comment) ?>
    <fieldset>
        <h5 class="subheader">Thread: <?= $thread->title ?></h5>
        <legend><?= __('Add Comment') ?></legend>
        <?php
            echo $this->Form->input('text');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
