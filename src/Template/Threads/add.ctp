<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Forums'), ['controller' => 'Forums', 'action' => 'index']) ?></li>
    </ul>
</div>
<div class="threads form large-10 medium-9 columns">
    <?= $this->Form->create($thread) ?>
    <fieldset>
        <h5 class="subheader">Forum: <?= $forum->title ?></h5>
        <legend><?= __('Add Thread') ?></legend>
        <?php
            echo $this->Form->input('title');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
