<?php

namespace common\models;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "shop_category".
 *
 * @property string $cateid
 * @property string $title
 * @property string $parentid
 * @property int $createtime
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parentid', 'createtime'], 'integer'],
            [['title'], 'string', 'max' => 32],
            ['parentid', 'required', 'message' => '上级分类不能为空', 'on' => ['add']],
            ['title', 'required', 'message' => '分类不能为空', 'on' => ['add']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cateid' => 'ID',
            'title' => '分类名称',
            'parentid' => '上级父类',
            'createtime' => 'Createtime',
        ];
    }
    public function add($data){
        $this->scenario = "add";
        if($this->load($data) && $this->validate()){
            $this->createtime = time();
            if($this->save(false)){
                return true;
            }
        }
        return false;
    }
    public function getData(){
        $data = self::find()->all();
        $data = $this->getTree(ArrayHelper::toArray($data));
        return $this->arrangement($data);
        
    }
    public function getTree($data,$pid = 0,$level = 1){
        $tree =  [];
        foreach ($data as $key => $val) {
            if($val['parentid'] == $pid){
                $val['level'] = $level;
                $val['title'] = str_repeat("|————",$level-1).$val['title'];
                $tree[] = $val;
                $tree = array_merge($tree,$this->getTree($data,$val['cateid'],$level+1));
            }
        }
        return $tree;
    }
    public function arrangement($data){
        $options = ['顶级分类'];
        foreach ($data as $cate) {
            $options[$cate['cateid']] = $cate['title'];
        }
        return $options;
    }

}
