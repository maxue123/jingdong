<?php

namespace common\models;
use common\models\Profile;
use Yii;

/**
 * This is the model class for table "shop_user".
 *
 * @property string $userid 主键ID
 * @property string $username
 * @property string $userpass
 * @property string $useremail
 * @property int $createtime
 */
class User extends \yii\db\ActiveRecord
{
    public $repass = '';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'required','message'=>'用户账号不能为空','on'=>['reg']],
            ['username', 'unique','message'=>'用户账号已被注册','on'=>['reg']],
            ['userpass', 'required','message'=>'用户密码不能为空','on'=>['reg']],

            ['useremail', 'required','message'=>'电子邮箱不能为空','on'=>['reg']],
            ['useremail', 'email','message'=>'电子邮箱格式不正确','on'=>['reg']],
            ['useremail', 'unique','message'=>'电子邮箱已被注册','on'=>['reg']],
            ['repass', 'required','message'=>'确认密码不能为空','on'=>['reg']],
            ['repass', 'compare','compareAttribute'=>'userpass','message'=>'两次密码不一致','on'=>['reg']],
            [['username', 'userpass'], 'unique', 'targetAttribute' => ['username', 'userpass']],
            [['useremail', 'userpass'], 'unique', 'targetAttribute' => ['useremail', 'userpass']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'userid' => 'ID',
            'username' => '用户账号',
            'userpass' => '用户密码',
            'useremail' => '用户邮箱',
            'repass' => '确认密码',
            'createtime' => 'Createtime',
        ];
    }
    public function reg($data){
        $this->scenario = "reg";
        if($this->load($data) && $this->validate()){
            $this->userpass = md5($data['User']['userpass']);
            $this->createtime = time();
            if($this->save(false)){
                return true;
            }
        }
        return false;
    }
    public function getProfile(){
        return $this->hasOne(Profile::className(),['userid'=>'userid']);
    }
}
