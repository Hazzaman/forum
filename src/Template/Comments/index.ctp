<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Comment'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Threads'), ['controller' => 'Threads', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Thread'), ['controller' => 'Threads', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="comments index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('thread_id') ?></th>
            <th><?= $this->Paginator->sort('user_id') ?></th>
            <th><?= $this->Paginator->sort('text') ?></th>
            <th><?= $this->Paginator->sort('created') ?></th>
            <th><?= $this->Paginator->sort('modified') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($comments as $comment): ?>
        <tr>
            <td><?= $this->Number->format($comment->id) ?></td>
            <td>
                <?= $comment->has('thread') ? $this->Html->link($comment->thread->title, ['controller' => 'Threads', 'action' => 'view', $comment->thread->id]) : '' ?>
            </td>
            <td>
                <?= $comment->has('user') ? $this->Html->link($comment->user->id, ['controller' => 'Users', 'action' => 'view', $comment->user->id]) : '' ?>
            </td>
            <td><?= h($comment->text) ?></td>
            <td><?= h($comment->created) ?></td>
            <td><?= h($comment->modified) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $comment->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $comment->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $comment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $comment->id)]) ?>
            </td>
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
