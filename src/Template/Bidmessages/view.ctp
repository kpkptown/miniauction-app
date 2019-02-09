<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Bidmessage $bidmessage
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Bidmessage'), ['action' => 'edit', $bidmessage->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Bidmessage'), ['action' => 'delete', $bidmessage->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bidmessage->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Bidmessages'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Bidmessage'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="bidmessages view large-9 medium-8 columns content">
    <h3><?= h($bidmessage->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($bidmessage->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Bidinfo Id') ?></th>
            <td><?= $this->Number->format($bidmessage->bidinfo_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User Id') ?></th>
            <td><?= $this->Number->format($bidmessage->user_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($bidmessage->created) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Message') ?></h4>
        <?= $this->Text->autoParagraph(h($bidmessage->message)); ?>
    </div>
</div>
