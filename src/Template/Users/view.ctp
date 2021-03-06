<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <?php if ($is_administrator || $userData['id'] == $user['id']): ?>
        <li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id]) ?> </li>
        <?php endif; ?>
        <li><?= $this->Html->link(__('List Forums'), ['controller' => 'Forums', 'action' => 'index']) ?></li>

    </ul>
</div>
<div class="users view large-10 medium-9 columns">
    <h2><?= h($user->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Username') ?></h6>
            <p><?= h($user->username) ?></p>
            <h6 class="subheader"><?= __('Email') ?></h6>
            <p><?= h($user->email) ?></p>
            
            <?php if (!is_null($user->administrator)): ?>
                <span class="subheader">Administrator</span>
            <?php endif; ?>
            <?php if (!is_null($user->moderator)): ?>
                <span class="subheader">Moderator</span>
            <?php endif; ?>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($user->id) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Created') ?></h6>
            <p><?= h($user->created) ?></p>
        </div>
        
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Comments') ?></h4>
    <?php if (!empty($user->comments)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Thread Id') ?></th>
            <th><?= __('User Id') ?></th>
            <th><?= __('Text') ?></th>
            <th><?= __('Created') ?></th>
            <th><?= __('Modified') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($user->comments as $comments): ?>
        <tr>
            <td><?= h($comments->id) ?></td>
            <td><?= h($comments->thread_id) ?></td>
            <td><?= h($comments->user_id) ?></td>
            <td><?= h($comments->text) ?></td>
            <td><?= h($comments->created) ?></td>
            <td><?= h($comments->modified) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Comments', 'action' => 'view', $comments->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Comments', 'action' => 'edit', $comments->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Comments', 'action' => 'delete', $comments->id], ['confirm' => __('Are you sure you want to delete # {0}?', $comments->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    <?php if (!is_null($user->moderator)): ?>
        <h4 class="subheader"><?= __('Moderating Forums') ?></h4>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Forum Id') ?></th>
                <th><?= __('Title') ?></th>
                <th><?= __('Created') ?></th>
            </tr>
            <?php foreach ($user->moderator->moderators_forums as $mods_forums): ?>
                <tr>
                  <td><?= h($mods_forums->forum->id) ?></td>
                  <td> <?= $this->Html->link(__($mods_forums->forum->title), ['controller' => 'Forums', 'action' => 'view', $mods_forums->forum->id]) ?></td>
                  <td><?= h($mods_forums->forum->created) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
</div>