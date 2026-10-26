<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Book;

/**
 * Trang XEM danh sách sách trong kho (bảng books).
 * Người thực hiện: (ghi tên bạn) - bước 7: giao diện và kiểm thử
 */
class BookController extends Controller
{
    /** Danh sách tất cả sách, sắp xếp theo tên */
    public function actionIndex()
    {
        $books = Book::find()->orderBy(['title' => SORT_ASC])->all();

        return $this->render('index', ['books' => $books]);
    }
}
