<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Forums'), ['controller' => 'Forums', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Forum'), ['action' => 'add']) ?></li>
        <?php if ($is_administrator): ?>
        <li><?= $this->Html->link(__('List Threads'), ['controller' => 'Threads', 'action' => 'index']) ?></li>
        <?php endif; ?>
    </ul>
</div>
<div class="forums form large-10 medium-9 columns">
    <?= $this->Form->create($forum) ?>
    <fieldset>
        <legend><?= __('Edit Forum') ?></legend>
        <?php
            echo $this->Form->input('title');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
