<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Chi tiết đơn hàng #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Danh sách giỏ hàng', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cart-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Quay lại danh sách', ['index'], ['class' => 'btn btn-secondary', 'style' => 'margin-bottom: 15px;']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => 'Tên sách',
                'value' => function ($model) {
                    if (isset($model->book) && $model->book) {
                        return $model->book->title ?? $model->book->name;
                    }
                    return 'Sách #' . $model->book_id;
                },
            ],
            [
                'label' => 'Đơn giá',
                'value' => function ($model) {
                    $price = $model->price ?? ($model->book->price ?? 0);
                    return number_format($price, 0, ',', '.') . ' VNĐ';
                },
            ],
            'quantity',
            [
                'label' => 'Thành tiền',
                'value' => function ($model) {
                    $price = $model->price ?? ($model->book->price ?? 0);
                    return number_format($price * $model->quantity, 0, ',', '.') . ' VNĐ';
                },
            ],
            [
                'label' => 'Trạng thái đơn hàng',
                'format' => 'raw',
                'value' => function ($model) {
                    $status = $model->cart->status ?? ($model->status ?? 0);
                    return $status == 1 
                        ? '<span style="color: green; font-weight: bold;">Đã duyệt</span>' 
                        : '<span style="color: orange; font-weight: bold;">Chờ duyệt</span>';
                },
            ],
        ],
    ]) ?>
</div>