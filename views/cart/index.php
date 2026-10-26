<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Danh sách giỏ hàng / Đơn hàng';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cart-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 1. Tên sách
            [
                'attribute' => 'book_id',
                'label' => 'Tên sách',
                'value' => function ($model) {
                    if (isset($model->book) && $model->book) {
                        return $model->book->title ?? $model->book->name;
                    }
                    return 'Sách #' . $model->book_id;
                },
            ],

            // 2. Đơn giá
            [
                'label' => 'Đơn giá',
                'value' => function ($model) {
                    $price = $model->price ?? ($model->book->price ?? 0);
                    return number_format($price, 0, ',', '.') . ' VNĐ';
                },
            ],

            // 3. Số lượng
            [
                'attribute' => 'quantity',
                'label' => 'Số lượng',
            ],

            // 4. Thành tiền
            [
                'label' => 'Thành tiền',
                'value' => function ($model) {
                    $price = $model->price ?? ($model->book->price ?? 0);
                    return number_format($price * $model->quantity, 0, ',', '.') . ' VNĐ';
                },
            ],

            // 5. Trạng thái duyệt đơn
            [
                'label' => 'Trạng thái duyệt đơn',
                'format' => 'raw',
                'value' => function ($model) {
                    $status = $model->cart->status ?? ($model->status ?? 0);
                    if ($status == 1) {
                        return '<span class="badge bg-success" style="background-color:#198754; color:#fff; padding:6px 10px; border-radius:4px;">Đã duyệt</span>';
                    }
                    return '<span class="badge bg-warning" style="background-color:#ffc107; color:#000; padding:6px 10px; border-radius:4px;">Chờ duyệt</span>';
                },
            ],

            // Cột nút thao tác
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update}',
            ],
        ],
    ]); ?>
</div>