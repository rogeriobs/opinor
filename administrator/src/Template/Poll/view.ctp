<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Poll'), ['action' => 'edit', $poll->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Poll'), ['action' => 'delete', $poll->id], ['confirm' => __('Are you sure you want to delete # {0}?', $poll->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Poll'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Poll'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Newsortopic'), ['controller' => 'Newsortopic', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Newsortopic'), ['controller' => 'Newsortopic', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Poll Options'), ['controller' => 'PollOptions', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Poll Option'), ['controller' => 'PollOptions', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Poll Options Votes'), ['controller' => 'PollOptionsVotes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Poll Options Vote'), ['controller' => 'PollOptionsVotes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="poll view large-9 medium-8 columns content">
    <h3><?= h($poll->titulo) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Titulo') ?></th>
            <td><?= h($poll->titulo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($poll->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Expiration Date') ?></th>
            <td><?= h($poll->expiration_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($poll->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($poll->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Shutoff') ?></th>
            <td><?= $poll->shutoff ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Newsortopic') ?></h4>
        <?php if (!empty($poll->newsortopic)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Titulo') ?></th>
                <th scope="col"><?= __('Alias') ?></th>
                <th scope="col"><?= __('Data De Publicacao') ?></th>
                <th scope="col"><?= __('Data Da Fonte') ?></th>
                <th scope="col"><?= __('Texto Resumo') ?></th>
                <th scope="col"><?= __('Texto Full') ?></th>
                <th scope="col"><?= __('Meta Title') ?></th>
                <th scope="col"><?= __('Meta Description') ?></th>
                <th scope="col"><?= __('Meta Keywords') ?></th>
                <th scope="col"><?= __('Shutoff') ?></th>
                <th scope="col"><?= __('Poll Id') ?></th>
                <th scope="col"><?= __('Format Article') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col"><?= __('Dominus Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($poll->newsortopic as $newsortopic): ?>
            <tr>
                <td><?= h($newsortopic->id) ?></td>
                <td><?= h($newsortopic->titulo) ?></td>
                <td><?= h($newsortopic->alias) ?></td>
                <td><?= h($newsortopic->data_de_publicacao) ?></td>
                <td><?= h($newsortopic->data_da_fonte) ?></td>
                <td><?= h($newsortopic->texto_resumo) ?></td>
                <td><?= h($newsortopic->texto_full) ?></td>
                <td><?= h($newsortopic->meta_title) ?></td>
                <td><?= h($newsortopic->meta_description) ?></td>
                <td><?= h($newsortopic->meta_keywords) ?></td>
                <td><?= h($newsortopic->shutoff) ?></td>
                <td><?= h($newsortopic->poll_id) ?></td>
                <td><?= h($newsortopic->format_article) ?></td>
                <td><?= h($newsortopic->created) ?></td>
                <td><?= h($newsortopic->modified) ?></td>
                <td><?= h($newsortopic->dominus_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Newsortopic', 'action' => 'view', $newsortopic->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Newsortopic', 'action' => 'edit', $newsortopic->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Newsortopic', 'action' => 'delete', $newsortopic->id], ['confirm' => __('Are you sure you want to delete # {0}?', $newsortopic->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Poll Options') ?></h4>
        <?php if (!empty($poll->poll_options)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Label Text') ?></th>
                <th scope="col"><?= __('Poll Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col"><?= __('Ordem') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($poll->poll_options as $pollOptions): ?>
            <tr>
                <td><?= h($pollOptions->id) ?></td>
                <td><?= h($pollOptions->label_text) ?></td>
                <td><?= h($pollOptions->poll_id) ?></td>
                <td><?= h($pollOptions->created) ?></td>
                <td><?= h($pollOptions->modified) ?></td>
                <td><?= h($pollOptions->ordem) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'PollOptions', 'action' => 'view', $pollOptions->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'PollOptions', 'action' => 'edit', $pollOptions->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'PollOptions', 'action' => 'delete', $pollOptions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pollOptions->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Poll Options Votes') ?></h4>
        <?php if (!empty($poll->poll_options_votes)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Ipsum Id') ?></th>
                <th scope="col"><?= __('Poll Options Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col"><?= __('Poll Id') ?></th>
                <th scope="col"><?= __('Ip') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($poll->poll_options_votes as $pollOptionsVotes): ?>
            <tr>
                <td><?= h($pollOptionsVotes->ipsum_id) ?></td>
                <td><?= h($pollOptionsVotes->poll_options_id) ?></td>
                <td><?= h($pollOptionsVotes->created) ?></td>
                <td><?= h($pollOptionsVotes->modified) ?></td>
                <td><?= h($pollOptionsVotes->poll_id) ?></td>
                <td><?= h($pollOptionsVotes->ip) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'PollOptionsVotes', 'action' => 'view', $pollOptionsVotes->ipsum_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'PollOptionsVotes', 'action' => 'edit', $pollOptionsVotes->ipsum_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'PollOptionsVotes', 'action' => 'delete', $pollOptionsVotes->ipsum_id], ['confirm' => __('Are you sure you want to delete # {0}?', $pollOptionsVotes->ipsum_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
