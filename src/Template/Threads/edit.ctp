<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $thread->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $thread->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Threads'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Forums'), ['controller' => 'Forums', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Forum'), ['controller' => 'Forums', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Comments'), ['controller' => 'Comments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Comment'), ['controller' => 'Comments', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="threads form large-10 medium-9 columns">
    <?= $this->Form->create($thread) ?>
    <fieldset>
        <legend><?= __('Edit Thread') ?></legend>
        <?php
            echo $this->Form->input('forum_id', ['options' => $forums]);
            echo $this->Form->input('title');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
