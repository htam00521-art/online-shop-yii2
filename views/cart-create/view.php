<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Cart $cart */
/** @var array $rows   mỗi phần tử: ['book' => Book, 'quantity' => int, 'subtotal' => float] */
/** @var float $total */
/** @var app\models\Book[] $books  các sách còn hàng (stock > 0) */

$this->title = 'Giỏ hàng #' . $cart->id;
$this->registerCssFile('@web/css/shop.css');

$formatter = Yii::$app->formatter;
$tongSoLuong = array_sum(array_column($rows, 'quantity'));
?>
<div class="shop-page">

    <?php foreach (Yii::$app->session->getAllFlashes(true) as $type => $message): ?>
        <div class="shop-alert shop-alert--<?= $type === 'success' ? 'success' : 'error' ?>">
            <?= Html::encode($message) ?>
        </div>
    <?php endforeach; ?>

    <?= Html::a('← Danh sách giỏ hàng', ['index'], ['class' => 'shop-back']) ?>

    <div class="shop-head">
        <div>
            <h1 class="shop-title"><?= Html::encode($this->title) ?></h1>
            <p class="shop-sub">
                Tạo lúc <?= $formatter->asDatetime($cart->created_at, 'php:d/m/Y H:i') ?>
            </p>
        </div>
    </div>

    <div class="shop-layout">

        <!-- ===== Cột trái: các sách trong giỏ ===== -->
        <section class="shop-card">
            <div class="shop-stats">
                <div class="shop-stat">
                    <span class="shop-stat__label">Đầu sách</span>
                    <span class="shop-stat__value"><?= count($rows) ?></span>
                </div>
                <div class="shop-stat">
                    <span class="shop-stat__label">Tổng số cuốn</span>
                    <span class="shop-stat__value"><?= (int) $tongSoLuong ?></span>
                </div>
            </div>

            <?php if (empty($rows)): ?>
                <p class="shop-empty">Giỏ hàng đang trống. Chọn sách ở khung bên phải để thêm vào giỏ.</p>
            <?php else: ?>
                <div class="shop-table-wrap">
                    <table class="shop-table">
                        <thead>
                            <tr>
                                <th>Sách</th>
                                <th class="shop-num">Đơn giá</th>
                                <th class="shop-center">Số lượng</th>
                                <th class="shop-num">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($rows as $row): ?>
                            <tr>
                                <td>
                                    <span class="shop-book"><?= Html::encode($row['book']->title) ?></span>
                                    <span class="shop-author"><?= Html::encode($row['book']->author) ?></span>
                                </td>
                                <td class="shop-num shop-money"><?= number_format((float) $row['book']->price, 0, ',', '.') ?>đ</td>
                                <td class="shop-center"><?= (int) $row['quantity'] ?></td>
                                <td class="shop-num shop-money"><?= number_format((float) $row['subtotal'], 0, ',', '.') ?>đ</td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="shop-num">Tổng cộng</th>
                                <td class="shop-num shop-total"><?= number_format((float) $total, 0, ',', '.') ?>đ</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            <?php endif; ?>
        </section>

        <!-- ===== Cột phải: form thêm sách ===== -->
        <aside class="shop-card">
            <h2 class="shop-card__title">Thêm sách vào giỏ</h2>

            <?php if (empty($books)): ?>
                <p class="shop-empty">Hiện không còn sách nào trong kho.</p>
            <?php else: ?>
                <?php
                // Tạo danh sách lựa chọn: [id sách => "Tên sách - giá"]
                $options = [];
                foreach ($books as $b) {
                    $options[$b->id] = $b->title . ' — ' . number_format((float) $b->price, 0, ',', '.') . 'đ (còn ' . (int) $b->stock . ')';
                }
                ?>
                <!-- Action "add-item" chỉ nhận POST; Html::beginForm tự gắn mã CSRF -->
                <?= Html::beginForm(['add-item', 'id' => $cart->id], 'post') ?>
                    <div class="shop-field">
                        <label class="shop-label" for="book_id">Chọn sách</label>
                        <?= Html::dropDownList('book_id', null, $options, ['id' => 'book_id', 'class' => 'shop-input']) ?>
                    </div>
                    <div class="shop-field">
                        <label class="shop-label" for="quantity">Số lượng</label>
                        <?= Html::input('number', 'quantity', 1, ['id' => 'quantity', 'class' => 'shop-input', 'min' => 1]) ?>
                        <span class="shop-hint">Không vượt quá số cuốn còn trong kho.</span>
                    </div>
                    <?= Html::submitButton('Thêm vào giỏ', ['class' => 'shop-btn shop-btn--primary shop-btn--block']) ?>
                <?= Html::endForm() ?>
            <?php endif; ?>
        </aside>

    </div>
</div>
