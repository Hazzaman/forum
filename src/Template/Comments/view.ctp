<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Forums'), ['controller' => 'Forums', 'action' => 'index']) ?></li>
    </ul>
</div>
<div class="comments view large-10 medium-9 columns">
    <br/>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Thread') ?></h6>
            <p><?= $comment->has('thread') ? $this->Html->link($comment->thread->title, ['controller' => 'Threads', 'action' => 'view', $comment->thread->id]) : '' ?></p>
            <h6 class="subheader"><?= __('User') ?></h6>
            <p><?= $comment->has('user') ? $this->Html->link($comment->user->username, ['controller' => 'Users', 'action' => 'view', $comment->user->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Text') ?></h6>
            <p><?= h($comment->text) ?></p>
        </div>
        <?php if ($is_administrator): ?>
            <div class="large-2 columns numbers end">
                <h6 class="subheader"><?= __('Id') ?></h6>
                <p><?= $this->Number->format($comment->id) ?></p>
            </div>
        <?php endif; ?>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Created') ?></h6>
            <p><?= h($comment->created) ?></p>
            <h6 class="subheader"><?= __('Modified') ?></h6>
            <p><?= h($comment->modified) ?></p>
        </div>
    </div>
</div>
