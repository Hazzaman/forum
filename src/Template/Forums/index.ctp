<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Forum'), ['action' => 'add']) ?></li>
        <?php if ($is_administrator): ?>
        <li><?= $this->Html->link(__('List Threads'), ['controller' => 'Threads', 'action' => 'index']) ?></li>
        <?php endif; ?>
    </ul>
</div>
<div class="forums index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('title') ?></th>
            <th><?= $this->Paginator->sort('created') ?></th>
            <?php if (isset($userData['administrator'])): ?>
                <th class="actions"><?= __('Actions') ?></th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($forums as $forum): ?>
        <tr>
            <td><?= $this->Number->format($forum->id) ?></td>
            <td><?= $this->Html->link(__($forum->title), ['action' => 'view', $forum->id]) ?></td>
            <td><?= h($forum->created) ?></td>
            <?php if (isset($userData['administrator'])): ?>
                <td class="actions">
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $forum->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $forum->id], ['confirm' => __('Are you sure you want to delete # {0}?', $forum->id)]) ?>
                </td>
            <?php endif; ?>
        </tr>

    <?php endforeach; ?>
    </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
