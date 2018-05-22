<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "shop_product".
 *
 * @property string $productid
 * @property string $cateid
 * @property string $title
 * @property string $descr
 * @property int $num
 * @property string $price
 * @property string $cover
 * @property string $pics
 * @property string $issale
 * @property string $ishot
 * @property string $istui
 * @property string $saleprice
 * @property string $ison
 * @property int $createtime
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%product}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cateid', 'num', 'createtime'], 'integer'],
            [['descr', 'pics', 'issale', 'ishot', 'istui', 'ison'], 'string'],
            [['price', 'saleprice'], 'number'],
            [['title', 'cover'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'productid' => 'ID',
            'cateid' => '分类',
            'title' => '名称',
            'descr' => '商品介绍',
            'num' => '库存',
            'price' => '价格',
            'cover' => '图片封面',
            'pics' => '商品图片',
            'issale' => '是否促销',
            'ishot' => '是否热卖',
            'istui' => '是否推荐',
            'saleprice' => '销售价格',
            'ison' => '是否下架',
            'createtime' => '创建时间',
        ];
    }
    public function add(){
        var_dump('1111111');die();
    }
}
