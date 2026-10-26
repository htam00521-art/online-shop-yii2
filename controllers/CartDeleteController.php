<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Cart;
use app\models\CartItem;
use app\models\Book;

/**
 * Chuc nang DELETE - Hieu Tam
 * Xoa sach khoi gio va xoa gio hang.
 *
 * Phien ban CRUD demo cho database online_shop.
 * Chua co quan ly chu so huu va trang thai duyet.
 */
class CartDeleteController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'remove-item' => ['POST'],
                    'delete-cart' => ['POST'],
                ],
            ],
        ];
    }

    // Hien thi danh sach gio hang
    public function actionIndex()
    {
        $carts = Cart::find()
            ->orderBy(['id' => SORT_DESC])
            ->all();

        return $this->render('index', [
            'carts' => $carts,
        ]);
    }

    // Xoa mot cuon sach khoi gio hang
    public function actionRemoveItem($id)
    {
        $item = CartItem::findOne($id);

        if ($item === null) {
            throw new NotFoundHttpException(
                'Khong tim thay sach trong gio hang.'
            );
        }

        $cartId = $item->cart_id;

        $transaction = Yii::$app->db->beginTransaction();

        try {
            if ($item->delete() === false) {
                throw new \RuntimeException(
                    'Khong the xoa sach.'
                );
            }

            $cart = Cart::findOne($cartId);

            if ($cart !== null) {
                $cart->updated_at = time();
                $cart->save(false);
            }

            $transaction->commit();

            Yii::$app->session->setFlash(
                'success',
                'Da xoa sach khoi gio hang.'
            );
        } catch (\Throwable $e) {
            $transaction->rollBack();

            Yii::$app->session->setFlash(
                'error',
                'Xoa sach that bai.'
            );
        }

        return $this->redirect(['index']);
    }

    // Xoa toan bo gio hang
    public function actionDeleteCart($id)
    {
        $cart = Cart::findOne($id);

        if ($cart === null) {
            throw new NotFoundHttpException(
                'Gio hang khong ton tai.'
            );
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            // Xoa chi tiet gio hang truoc
            CartItem::deleteAll(['cart_id' => $cart->id]);

            // Xoa gio hang
            if ($cart->delete() === false) {
                throw new \RuntimeException(
                    'Khong the xoa gio hang.'
                );
            }

            $transaction->commit();

            Yii::$app->session->setFlash(
                'success',
                'Da xoa toan bo gio hang.'
            );
        } catch (\Throwable $e) {
            $transaction->rollBack();

            Yii::$app->session->setFlash(
                'error',
                'Xoa gio hang that bai.'
            );
        }

        return $this->redirect(['index']);
    }
}
