<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css('styles.css') ?>
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>
    

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <header>
        <div class="header-title">
            <span><?= $this->fetch('title') ?></span>
        </div>
        <div class="header-help">
            <span><a target="_blank" href="http://book.cakephp.org/3.0/">Documentation</a></span>
            <span><a target="_blank" href="http://api.cakephp.org/3.0/">API</a></span>
            <?php if ($is_administrator): ?>
              <span><a href="<?= $this->Url->build(['controller' => 'generator', 'action' => 'newRecords']);?>">New Records</a></span>
              <span><a href="<?= $this->Url->build(['controller' => 'generator', 'action' => 'delete']);?>">Delete Records</a></span>
            <?php endif; ?>
            
            <?php if (isset($userData)) { ?>
            <span id="user-profile-link">
                <?= $this->Html->link($userData['username'], ['controller' => 'Users', 'action' => 'view', $userData['id']]); ?> <br/>
                <?= $this->Html->link('Logout', ['controller' => 'Users', 'action' => 'logout']); ?>
            </span>
            <?php } else {?>
            <span id="user-login-links">
                <?= $this->Html->link('Login', ['controller' => 'Users', 'action' => 'login']); ?> <br /> <br />
                <?= $this->Html->link('Register', ['controller' => 'Users', 'action' => 'add']); ?>
            </span>
            <?php } ?>
        </div>
    </header>
    <div id="container">

        <div id="content">
            <?= $this->Flash->render() ?>
            <?= $this->Flash->render('auth') ?>

            <div class="row">
                <?= $this->fetch('content') ?>
            </div>
        </div>
        <footer>
        </footer>
    </div>
</body>
</html>
