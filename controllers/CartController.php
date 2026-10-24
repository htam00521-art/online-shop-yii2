<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
// Khai báo các model tương ứng (chỉnh sửa tên nếu Thắng đặt tên có s hoặc không có s)
use app\models\CartItem; 
use app\models\Cart;

class CartController extends Controller
{
    /**
     * Danh sách giỏ hàng / đơn hàng
     * Hiển thị: Tên sách, đơn giá, số lượng, thành tiền, trạng thái
     */
    public function actionIndex()
    {
        // Nếu tên model trong thư mục models của bạn là CartItems thì đổi CartItem thành CartItems
        $query = class_exists('app\models\CartItem') 
            ? \app\models\CartItem::find() 
            : \app\models\CartItems::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Trang xem chi tiết một mục trong giỏ hàng / đơn hàng
     */
    public function actionView($id)
    {
        $class = class_exists('app\models\CartItem') ? '\app\models\CartItem' : '\app\models\CartItems';
        $model = $class::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException('Mục giỏ hàng này không tồn tại.');
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }
}