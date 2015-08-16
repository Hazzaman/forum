<?= $this->assign('title', 'Thread'); ?>
<!--<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Thread'), ['action' => 'edit', $thread->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Thread'), ['action' => 'delete', $thread->id], ['confirm' => __('Are you sure you want to delete # {0}?', $thread->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Threads'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Thread'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Forums'), ['controller' => 'Forums', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Forum'), ['controller' => 'Forums', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Comments'), ['controller' => 'Comments', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Comment'), ['controller' => 'Comments', 'action' => 'add']) ?> </li>
    </ul>
</div>-->
<div class="threads view large-10 medium-9 columns">
    <h6><?= $this->Html->link($thread->forum->title, ['controller' => 'Forums', 'action' => 'view', $thread->forum->id]) ?></h6>
    <h2><?= h($thread->title) ?></h2>
    <!--<div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Title') ?></h6>
            <p><?= h($thread->title) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($thread->id) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Created') ?></h6>
            <p><?= h($thread->created) ?></p>
        </div>-->
    </div>
</div>
<?= $this->Html->link(__('New Comment'), ['controller' => 'comments', 'action' => 'add', $thread->id]) ?>
<div class="related row">
    <div class="column large-12">
    <!--<h4 class="subheader"><?= __('Related Comments') ?></h4>-->
    <?php if (!empty($thread->comments)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <!--<th><?= __('Id') ?></th>
            <th><?= __('Thread Id') ?></th>
            <th><?= __('User Id') ?></th>
            <th><?= __('Text') ?></th>
            <th><?= __('Created') ?></th>
            <th><?= __('Modified') ?></th>-->
            <th class="actions"><?= __('Comments') ?></th>
        </tr>
        <?php foreach ($thread->comments as $comments): ?>
        <tr>            
            <td class="comment">
                <?=h($comments->id);?>
                <span class="comment_header"><?=$this->Html->link($userdata[$comments->user_id]['username'], ['controller' => 'Users', 'action' => 'view', $comments->user_id])?>
                    <span class="comment_time">
                        <b>Created: </b><?=h($comments->created);?>
                        <?php echo ($comments->modified ? '<b>Modified: </b>' . h($comments->modified) : null);?>
                    </span>
                </span>
                <div><?=h($comments->text);?></div>
                <div class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Comments', 'action' => 'view', $comments->id]) ?>
                    
                    <?php if(($comments->user_id === $userData['id']) || $is_moderator === true) {?>
                        <?= $this->Html->link(__('Edit'), ['controller' => 'Comments', 'action' => 'edit', $comments->id]) ?>

                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'Comments', 'action' => 'delete', $comments->id], ['confirm' => __('Are you sure you want to delete # {0}?', $comments->id)]) ?>
                    <?php } ?>
                </div>
            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
