<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
// Khai báo các model tương ứng (chỉnh sửa tên nếu Thắng đặt tên có s hoặc không có s)
use app\models\CartItem; 
use app\models\Cart;
use app\models\Book;

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
public function actionUpdate($id)
    {
        $model = CartItem::findOne($id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            // 4. Chỉ cho phép sửa giỏ hàng chưa duyệt
            $cart = Cart::findOne($model->cart_id);
            if ($cart && $cart->status !== 'pending') { // Sửa 'pending' thành trạng thái chưa duyệt trong DB của bạn
                Yii::$app->session->setFlash('error', 'Chỉ được phép sửa giỏ hàng chưa duyệt.');
                return $this->redirect(['index']);
            }

            // 3. Kiểm tra số lượng hợp lệ và tồn kho
            $book = Book::findOne($model->book_id);
            if ($book) {
                if ($model->quantity <= 0) {
                    Yii::$app->session->setFlash('error', 'Số lượng phải lớn hơn 0.');
                } elseif ($model->quantity > $book->stock) { // 'stock' là cột số lượng tồn trong bảng sách
                    Yii::$app->session->setFlash('error', 'Số lượng vượt quá tồn kho hiện có.');
                } else {
                    // 5. Cập nhật tổng tiền sau khi sửa
                  //  $model->sub_total = $model->quantity * $book->price; // 'price' là đơn giá sách
                    
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Cập nhật số lượng thành công.');
                        return $this->redirect(['index']);
                    }
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
}