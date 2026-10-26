<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;

/** @var yii\web\View $this */
/** @var app\models\Book[] $books */

$this->title = 'Danh sách sách';
$this->registerCssFile('@web/css/shop.css');
?>
<div class="shop-page">

    <div class="shop-head">
        <div>
            <h1 class="shop-title"><?= Html::encode($this->title) ?></h1>
            <p class="shop-sub">Có <?= count($books) ?> đầu sách trong kho.</p>
        </div>
        <?= Html::a('Đi tới giỏ hàng', ['/cart-create/index'], ['class' => 'shop-btn shop-btn--primary']) ?>
    </div>

    <div class="shop-card">
        <?php if (empty($books)): ?>
            <p class="shop-empty">Chưa có sách nào trong kho.</p>
        <?php else: ?>
            <div class="shop-table-wrap">
                <table class="shop-table">
                    <thead>
                        <tr>
                            <th>Mã</th>
                            <th>Sách</th>
                            <th class="shop-num">Giá</th>
                            <th class="shop-center">Tồn kho</th>
                            <th>Mô tả</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($books as $book): ?>
                        <tr>
                            <td><span class="shop-code">#<?= (int) $book->id ?></span></td>
                            <td>
                                <span class="shop-book"><?= Html::encode($book->title) ?></span>
                                <span class="shop-author"><?= Html::encode($book->author) ?></span>
                            </td>
                            <td class="shop-num shop-money"><?= number_format((float) $book->price, 0, ',', '.') ?>đ</td>
                            <td class="shop-center"><?= (int) $book->stock > 0 ? (int) $book->stock : 'Hết hàng' ?></td>
                            <td><?= Html::encode(StringHelper::truncate((string) $book->description, 70)) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
