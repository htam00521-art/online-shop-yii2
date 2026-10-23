<?php
namespace app\models;

use yii\db\ActiveRecord;

class CartItem extends ActiveRecord
{
    public static function tableName()
    {
        return 'cart_items';
    }

    public function rules()
    {
        return [
            [['cart_id', 'book_id', 'quantity'], 'required'],
            [['cart_id', 'book_id', 'quantity'], 'integer'],
            [['quantity'], 'integer', 'min' => 1],
        ];
    }

    public function getCart()
    {
        return $this->hasOne(Cart::class, ['id' => 'cart_id']);
    }

    public function getBook()
    {
        return $this->hasOne(Book::class, ['id' => 'book_id']);
    }
}
