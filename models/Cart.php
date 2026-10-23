<?php
namespace app\models;

use yii\db\ActiveRecord;

class Cart extends ActiveRecord
{
    public static function tableName()
    {
        return 'carts';
    }

    public function getCartItems()
    {
        return $this->hasMany(CartItem::class, ['cart_id' => 'id']);
    }
}
