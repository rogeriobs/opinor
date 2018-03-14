<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Poll'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Newsortopic'), ['controller' => 'Newsortopic', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Newsortopic'), ['controller' => 'Newsortopic', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Poll Options'), ['controller' => 'PollOptions', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Poll Option'), ['controller' => 'PollOptions', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Poll Options Votes'), ['controller' => 'PollOptionsVotes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Poll Options Vote'), ['controller' => 'PollOptionsVotes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="poll form large-9 medium-8 columns content">
    <?= $this->Form->create($poll) ?>
    <fieldset>
        <legend><?= __('Add Poll') ?></legend>
        <?php
            echo $this->Form->control('titulo');
            echo $this->Form->control('shutoff');
            echo $this->Form->control('expiration_date', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
