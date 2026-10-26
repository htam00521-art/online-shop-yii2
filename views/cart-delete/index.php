
<?php

use yii\helpers\Html;

$this->title = 'Quan ly xoa gio hang';

?>

<div class="container mt-4">

    <h2>Chức năng Delete - Giỏ hàng</h2>

    <p>Người thực hiện: Hiếu Tâm</p>

    <?php foreach ($carts as $cart): ?>

        <div class="card mb-3">

            <div class="card-header">
                <strong>
                    Giỏ hàng #<?= Html::encode($cart->id) ?>
                </strong>
            </div>

            <div class="card-body">

                <?php $items = $cart->cartItems; ?>

                <?php if (empty($items)): ?>
                    <p>Giỏ hàng đang trống.</p>
                <?php else: ?>

                    <table class="table table-bordered">

                        <thead>
                            <tr>
                                <th>ID sách</th>
                                <th>Tên sách</th>
                                <th>Số lượng</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>

                        <tbody>

                        <?php foreach ($items as $item): ?>

                            <tr>
                                <td>
                                    <?= Html::encode($item->book_id) ?>
                                </td>

                                <td>
                                    <?= Html::encode(
                                        $item->book
                                            ? $item->book->title
                                            : 'Không tìm thấy sách'
                                    ) ?>
                                </td>

                                <td>
                                    <?= Html::encode($item->quantity) ?>
                                </td>

                                <td>
                                    <?= Html::beginForm(
                                        [
                                            '/cart-delete/remove-item',
                                            'id' => $item->id
                                        ],
                                        'post'
                                    ) ?>

                                    <?= Html::submitButton(
                                        'Xóa sách',
                                        [
                                            'class' => 'btn btn-warning btn-sm',
                                            'data-confirm' =>
                                                'Bạn chắc chắn muốn xóa sách này?'
                                        ]
                                    ) ?>

                                    <?= Html::endForm() ?>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                        </tbody>
                    </table>

                <?php endif; ?>

                <?= Html::beginForm(
                    [
                        '/cart-delete/delete-cart',
                        'id' => $cart->id
                    ],
                    'post'
                ) ?>

                <?= Html::submitButton(
                    'Xóa toàn bộ giỏ hàng',
                    [
                        'class' => 'btn btn-danger',
                        'data-confirm' =>
                            'Bạn chắc chắn muốn xóa toàn bộ giỏ hàng?'
                    ]
                ) ?>

                <?= Html::endForm() ?>

            </div>
        </div>

    <?php endforeach; ?>

</div>
