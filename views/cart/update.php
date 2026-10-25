<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CartItem */

$this->title = 'Cập nhật số lượng sách';
?>
<div class="cart-item-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="cart-item-form">
        <?php $form = ActiveForm::begin(); ?>

        <!-- Form nhập số lượng -->
        <?= $form->field($model, 'quantity')->textInput([
            'type' => 'number', 
            'min' => 1
        ])->label('Nhập số lượng mới') ?>

        <div class="form-group">
            <?= Html::submitButton('Lưu thay đổi', ['class' => 'btn btn-success']) ?>
            <?= Html::a('Quay lại', ['index'], ['class' => 'btn btn-default btn-secondary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>