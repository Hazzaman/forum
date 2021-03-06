<?= $this->assign('title', 'Forum'); ?>
</div>
<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <!--<li><?= $this->Html->link(__('Edit Forum'), ['action' => 'edit', $forum->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Forum'), ['action' => 'delete', $forum->id], ['confirm' => __('Are you sure you want to delete # {0}?', $forum->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Forums'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Forum'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Threads'), ['controller' => 'Threads', 'action' => 'index']) ?> </li>-->
        <li><?= $this->Html->link(__('List Forums'), ['controller' => 'Forums', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Thread'), ['controller' => 'Threads', 'action' => 'add', $forum->id]) ?> </li>
        <?php if ($is_moderator || $is_administrator): ?>
            <li><?= $this->Html->link(__('Edit Forum'), ['controller' => 'Forums', 'action' => 'edit', $forum->id]) ?> </li>
        <?php endif; ?>    </ul>

        
</div>

<div class="forums view large-10 medium-9 columns">
    <h2><?= h($forum->title) ?></h2>
    <!--<div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Title') ?></h6>
            <p><?= h($forum->title) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($forum->id) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Created') ?></h6>
            <p><?= h($forum->created) ?></p>
        </div>
    </div>-->
</div>
<div class="related row">
    <div class="column large-12">
    <!--<h4 class="subheader"><?= __('Threads') ?></h4>-->
    <?php if (!empty($forum->threads)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Forum Id') ?></th>
            <th><?= __('Title') ?></th>
            <th><?= __('Created') ?></th>
            <?php if ($is_moderator || $is_administrator): ?>
                <th class="actions"><?= __('Actions') ?></th>
            <?php endif; ?>
        </tr>
        <?php foreach ($forum->threads as $threads): ?>
        <tr>
            <td><?= h($threads->id) ?></td>
            <td><?= h($threads->forum_id) ?></td>
            <td> <?= $this->Html->link(__($threads->title), ['controller' => 'Threads', 'action' => 'view', $threads->id]) ?></td>
            <td><?= h($threads->created) ?></td>
            <?php if ($is_moderator || $is_administrator): ?>
                <td class="actions">

                    <?= $this->Html->link(__('Edit'), ['controller' => 'Threads', 'action' => 'edit', $threads->id]) ?>

                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Threads', 'action' => 'delete', $threads->id], ['confirm' => __('Are you sure you want to delete # {0}?', $threads->id)]) ?>

                </td>
            <?php endif; ?>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
<div class="moderators">
<h4 class="subheader">Moderators</h4>
<?php if (empty($forum->moderators_forums)):?>
<span>No Moderators</span>
<?php endif; ?>
<?php foreach ($forum->moderators_forums as $mods_forums):?>
    <span><?= $this->Html->link($mods_forums->moderator->user->username, ['controller' => 'Users', 'action' => 'view', $mods_forums->moderator->user->id]) ?></span> <br/>
<?php endforeach; ?>
