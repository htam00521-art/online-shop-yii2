<?php
/** @var yii\web\View $this */
/** @var app\models\Cart $cart */
/** @var array $rows */
/** @var float $total */
/** @var app\models\Book[] $books */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$this->title = 'Giỏ hàng #' . $cart->id;
?>
<div class="cart-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php foreach (['success', 'error'] as $type): ?>
        <?php if (Yii::$app->session->hasFlash($type)): ?>
            <div class="alert alert-<?= $type === 'error' ? 'danger' : 'success' ?>">
                <?= Html::encode(Yii::$app->session->getFlash($type)) ?>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>

    <h4>Thêm sách vào giỏ</h4>
    <?= Html::beginForm(['cart/add-item', 'id' => $cart->id], 'post', ['class' => 'row g-2 mb-4']) ?>
        <div class="col-md-6">
            <?= Html::dropDownList('book_id', null,
                ArrayHelper::map($books, 'id', function ($b) {
                    return $b->title . ' - ' . number_format($b->price, 0, ',', '.') . 'đ (còn ' . $b->stock . ')';
                }), ['class' => 'form-select', 'prompt' => 'Chọn sách...']) ?>
        </div>
        <div class="col-md-2">
            <?= Html::input('number', 'quantity', 1, ['class' => 'form-control', 'min' => 1]) ?>
        </div>
        <div class="col-md-2">
            <?= Html::submitButton('Thêm vào giỏ', ['class' => 'btn btn-primary']) ?>
        </div>
    <?= Html::endForm() ?>

    <table class="table table-striped">
        <thead>
            <tr><th>Sách</th><th>Tác giả</th><th>Đơn giá</th><th>Số lượng</th><th>Thành tiền</th></tr>
        </thead>
        <tbody>
        <?php if (empty($rows)): ?>
            <tr><td colspan="5">Giỏ hàng đang trống. Chọn sách ở trên để thêm vào.</td></tr>
        <?php endif; ?>
        <?php foreach ($rows as $r): ?>
            <tr>
                <td><?= Html::encode($r['book']->title) ?></td>
                <td><?= Html::encode($r['book']->author) ?></td>
                <td><?= number_format($r['book']->price, 0, ',', '.') ?>đ</td>
                <td><?= $r['quantity'] ?></td>
                <td><?= number_format($r['subtotal'], 0, ',', '.') ?>đ</td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr><th colspan="4" class="text-end">Tổng cộng</th><th><?= number_format($total, 0, ',', '.') ?>đ</th></tr>
        </tfoot>
    </table>

    <?= Html::a('Quay lại danh sách giỏ hàng', ['cart/index'], ['class' => 'btn btn-secondary']) ?>
</div>