<?php
/** @var yii\web\View $this */
/** @var app\models\Cart[] $carts */

use yii\helpers\Html;

$this->title = 'Giỏ hàng';
?>
<div class="cart-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php foreach (['success', 'error'] as $type): ?>
        <?php if (Yii::$app->session->hasFlash($type)): ?>
            <div class="alert alert-<?= $type === 'error' ? 'danger' : 'success' ?>">
                <?= Html::encode(Yii::$app->session->getFlash($type)) ?>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>

    <?= Html::beginForm(['cart-create/create'], 'post') ?>
        <?= Html::submitButton('Tạo giỏ hàng mới', ['class' => 'btn btn-primary']) ?>
    <?= Html::endForm() ?>

    <table class="table table-striped mt-3">
        <thead>
            <tr><th>Mã giỏ</th><th>Ngày tạo</th><th></th></tr>
        </thead>
        <tbody>
        <?php if (empty($carts)): ?>
            <tr><td colspan="3">Chưa có giỏ hàng nào. Bấm "Tạo giỏ hàng mới" để bắt đầu.</td></tr>
        <?php endif; ?>
        <?php foreach ($carts as $cart): ?>
            <tr>
                <td>#<?= $cart->id ?></td>
                <td><?= date('d/m/Y H:i', $cart->created_at) ?></td>
                <td><?= Html::a('Xem giỏ', ['cart-create/view', 'id' => $cart->id], ['class' => 'btn btn-sm btn-outline-primary']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>