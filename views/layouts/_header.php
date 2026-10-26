<?php

declare(strict_types=1);

/** @var yii\web\View $this */

use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Html;

$items = [
    ['label' => 'Home', 'url' => ['/site/index']],
    ['label' => 'Danh sách giỏ', 'url' => ['/cart-create/index']],
    ['label' => 'Chi tiết giỏ hàng', 'url' => ['/cart-create/view', 'id' => 1]],
    ['label' => 'Sách', 'url' => ['/book/index']],
    ['label' => 'Danh sách các dòng giỏ', 'url' => ['/cart/index']],
    ['label' => 'Xoá sách', 'url' => ['/cart-delete/index']],
    
    // Phần hiển thị nút Login/Logout theo trạng thái tài khoản
    Yii::$app->user->isGuest
        ? ['label' => 'Login', 'url' => ['/site/login']]
        : '<li class="nav-item">'
            . Html::beginForm(['/site/logout'], 'post', ['class' => 'd-inline'])
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'nav-link btn btn-link logout']
            )
            . Html::endForm()
            . '</li>'
];

?>
<header id="header">
    <?php NavBar::begin(
        [
            'brandLabel' => 'Online Book Shop',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
        ],
    ) ?>
    <?= Nav::widget(
        [
            'options' => ['class' => 'navbar-nav me-auto'],
            'encodeLabels' => false,
            'items' => $items,
        ],
    ) ?>
    <?= Html::button(
        '&#127769;',
        [
            'id' => 'theme-toggle',
            'class' => 'btn btn-link nav-link fs-5',
            'aria-label' => 'Switch to dark mode',
        ],
    ) ?>
    <?php NavBar::end() ?>
</header>
