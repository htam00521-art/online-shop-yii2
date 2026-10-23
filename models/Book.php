<?php
namespace app\models;

use yii\db\ActiveRecord;

class Book extends ActiveRecord
{
    public static function tableName()
    {
        return 'books';
    }

    public function rules()
    {
        return [
            [['title', 'author'], 'required'],
            [['description'], 'string'],
            [['price'], 'number', 'min' => 0],
            [['stock'], 'integer', 'min' => 0],
            [['title'], 'string', 'max' => 255],
            [['author'], 'string', 'max' => 150],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'Mã sách',
            'title' => 'Tên sách',
            'author' => 'Tác giả',
            'price' => 'Giá sách',
            'stock' => 'Số lượng tồn kho',
            'description' => 'Mô tả',
            'created_at' => 'Ngày tạo',
            'updated_at' => 'Ngày cập nhật',
        ];
    }
}
