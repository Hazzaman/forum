<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Moderators'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Moderators Forums'), ['controller' => 'ModeratorsForums', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Moderators Forum'), ['controller' => 'ModeratorsForums', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="moderators form large-10 medium-9 columns">
    <?= $this->Form->create($moderator) ?>
    <fieldset>
        <legend><?= __('Add Moderator') ?></legend>
        <?php
            echo $this->Form->input('user_id', ['options' => $users]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
