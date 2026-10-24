<?php

namespace app\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\Book;
use app\models\Cart;
use app\models\CartItem;

/**
 * Chức năng CREATE: tạo giỏ hàng và thêm sách vào giỏ (bảng carts, cart_items).
 * Người thực hiện: Hoàng Quí - nhánh feature/create
 */
class CartCreateController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'create'   => ['post'],
                    'add-item' => ['post'],
                ],
            ],
        ];
    }

    /** Danh sách các giỏ hàng + nút tạo giỏ mới */
    public function actionIndex()
    {
        $carts = Cart::find()->orderBy(['id' => SORT_DESC])->all();
        return $this->render('index', ['carts' => $carts]);
    }

    /** Tạo giỏ hàng mới (ghi 1 dòng vào bảng carts) */
    public function actionCreate()
    {
        $cart = new Cart();
        $cart->created_at = time();
        $cart->updated_at = time();

        if ($cart->save(false)) {
            Yii::$app->session->setFlash('success', 'Đã tạo giỏ hàng #' . $cart->id . '.');
            return $this->redirect(['view', 'id' => $cart->id]);
        }

        Yii::$app->session->setFlash('error', 'Không thể tạo giỏ hàng.');
        return $this->redirect(['index']);
    }

    /** Xem chi tiết giỏ hàng, form thêm sách */
    public function actionView($id)
    {
        $cart  = $this->findCart($id);
        $items = CartItem::find()->where(['cart_id' => $cart->id])->all();
        $books = Book::find()->where(['>', 'stock', 0])->orderBy('title')->all();

        $total = 0;
        $rows  = [];
        foreach ($items as $item) {
            $book = Book::findOne($item->book_id);
            if ($book === null) {
                continue;
            }
            $subtotal = $book->price * $item->quantity;
            $total += $subtotal;
            $rows[] = ['book' => $book, 'quantity' => $item->quantity, 'subtotal' => $subtotal];
        }

        return $this->render('view', [
            'cart'  => $cart,
            'rows'  => $rows,
            'total' => $total,
            'books' => $books,
        ]);
    }

    /** Thêm sách vào giỏ: kiểm tra mã sách, số lượng, tồn kho */
    public function actionAddItem($id)
    {
        $cart = $this->findCart($id);
        $req  = Yii::$app->request;

        $bookId   = (int)$req->post('book_id');
        $quantity = (int)$req->post('quantity', 1);
        $session  = Yii::$app->session;

        // 1. Kiểm tra mã sách
        $book = Book::findOne($bookId);
        if ($book === null) {
            $session->setFlash('error', 'Mã sách không tồn tại.');
            return $this->redirect(['view', 'id' => $cart->id]);
        }

        // 2. Kiểm tra số lượng
        if ($quantity < 1) {
            $session->setFlash('error', 'Số lượng phải lớn hơn 0.');
            return $this->redirect(['view', 'id' => $cart->id]);
        }

        // 3. Kiểm tra tồn kho (tính cả số lượng đã có trong giỏ)
        $item = CartItem::findOne(['cart_id' => $cart->id, 'book_id' => $book->id]);
        $newQty = ($item ? $item->quantity : 0) + $quantity;
        if ($newQty > $book->stock) {
            $session->setFlash('error', 'Sách "' . $book->title . '" chỉ còn ' . $book->stock . ' cuốn trong kho.');
            return $this->redirect(['view', 'id' => $cart->id]);
        }

        // 4. Ghi dữ liệu vào MySQL (có transaction)
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($item === null) {
                $item = new CartItem();
                $item->cart_id    = $cart->id;
                $item->book_id    = $book->id;
                $item->created_at = time();
            }
            $item->quantity   = $newQty;
            $item->updated_at = time();
            $item->save(false);

            $cart->updated_at = time();
            $cart->save(false);

            $transaction->commit();
            $session->setFlash('success', 'Đã thêm "' . $book->title . '" vào giỏ hàng.');
        } catch (\Throwable $e) {
            $transaction->rollBack();
            $session->setFlash('error', 'Lỗi khi ghi dữ liệu: ' . $e->getMessage());
        }

        return $this->redirect(['view', 'id' => $cart->id]);
    }

    protected function findCart($id)
    {
        if (($cart = Cart::findOne($id)) !== null) {
            return $cart;
        }
        throw new NotFoundHttpException('Giỏ hàng không tồn tại.');
    }
}