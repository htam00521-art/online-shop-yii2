<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Cart[] $carts */

$this->title = 'Danh sách giỏ hàng';
$this->registerCssFile('@web/css/shop.css');

$formatter = Yii::$app->formatter;
?>
<div class="shop-page">

    <?php foreach (Yii::$app->session->getAllFlashes(true) as $type => $message): ?>
        <div class="shop-alert shop-alert--<?= $type === 'success' ? 'success' : 'error' ?>">
            <?= Html::encode($message) ?>
        </div>
    <?php endforeach; ?>

    <div class="shop-head">
        <div>
            <h1 class="shop-title"><?= Html::encode($this->title) ?></h1>
            <p class="shop-sub">Chọn một giỏ để xem và thêm sách, hoặc tạo giỏ mới.</p>
        </div>

        <!-- Action "create" chỉ nhận POST nên phải dùng form, không dùng thẻ <a> -->
        <?= Html::beginForm(['create'], 'post') ?>
            <?= Html::submitButton('+ Tạo giỏ hàng mới', ['class' => 'shop-btn shop-btn--primary']) ?>
        <?= Html::endForm() ?>
    </div>

    <div class="shop-card">
        <?php if (empty($carts)): ?>
            <p class="shop-empty">Chưa có giỏ hàng nào. Nhấn “Tạo giỏ hàng mới” để bắt đầu.</p>
        <?php else: ?>
            <div class="shop-table-wrap">
                <table class="shop-table">
                    <thead>
                        <tr>
                            <th>Mã giỏ</th>
                            <th>Ngày tạo</th>
                            <th>Cập nhật lần cuối</th>
                            <th class="shop-num">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($carts as $cart): ?>
                        <tr>
                            <td><span class="shop-code">#<?= (int) $cart->id ?></span></td>
                            <td><?= $formatter->asDatetime($cart->created_at, 'php:d/m/Y H:i') ?></td>
                            <td><?= $formatter->asDatetime($cart->updated_at, 'php:d/m/Y H:i') ?></td>
                            <td class="shop-num">
                                <?= Html::a('Xem giỏ', ['view', 'id' => $cart->id], ['class' => 'shop-btn shop-btn--ghost']) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
