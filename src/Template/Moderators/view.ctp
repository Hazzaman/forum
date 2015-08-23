<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Moderator'), ['action' => 'edit', $moderator->moderator_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Moderator'), ['action' => 'delete', $moderator->moderator_id], ['confirm' => __('Are you sure you want to delete # {0}?', $moderator->moderator_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Moderators'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Moderator'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Moderators Forums'), ['controller' => 'ModeratorsForums', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Moderators Forum'), ['controller' => 'ModeratorsForums', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="moderators view large-10 medium-9 columns">
    <h2><?= h($moderator->moderator_id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('User') ?></h6>
            <p><?= $moderator->has('user') ? $this->Html->link($moderator->user->username, ['controller' => 'Users', 'action' => 'view', $moderator->user->id]) : '' ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Moderator Id') ?></h6>
            <p><?= $this->Number->format($moderator->moderator_id) ?></p>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Moderators Forums') ?></h4>
    <?php if (!empty($moderator->moderators_forums)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Moderator Id') ?></th>
            <th><?= __('Forum Id') ?></th>
        </tr>
        <?php foreach ($moderator->moderators_forums as $moderatorsForums): ?>
        <tr>
            <td><?= h($moderatorsForums->id) ?></td>
            <td><?= h($moderatorsForums->moderator_id) ?></td>
            <td><?= h($moderatorsForums->forum_id) ?></td>

        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
