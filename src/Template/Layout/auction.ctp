<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" contant="width=device-width,initial-scale=1.0">
    <title>
        <?= $this->name . '/' . $this->request->action ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('auction.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <nav class="top-bar titlebar" data-topber role="navigation">
        <ul class="title-area large-3 medium-4 columuns name=">
            <li>
                <h1><?= $this->Html->link(__('Auction![' .$authuser['username'] . ']'),['action' => 'index']) ?></h1>
            </li>
        </ul>
        <div class="top-bar-section">
            <ul class="right">
                <li><a target="_blank" href="https://twitter.com/ask_kpkptown">about</a></li>
            </ul>
        </div>
    </nav>
    <?= $this->Flash->render() ?>
    <div class="container clearfix">
        <div class="actions index medium-9 columns content">
            <?= $this->fetch('content') ?>
        </div>
        <nav class="large-2 medium-3 columns sideber" id="actions-sideber">
            <ul class="side-nav">
                <li class="heading"><?= __('Actions') ?></li>
                <li><?= $this->Html->link(__('あなたの落札情報'),['action' => 'home']) ?></li>
                <li><?= $this->Html->link(__('あなたの出品情報'),['action' => 'home2']) ?></li>
                <li><?= $this->Html->link(__('商品を出品する'),['action' => 'add']) ?></li>
                <li><?= $this->Html->link(__('商品リストをみる'),['action' => 'index']) ?></li>
            </ul>
        </nav>
    </div>
    <footer>
    </footer>
</body>
</html>