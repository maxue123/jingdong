<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
class Admin extends ActiveRecord{
	public $rememberMe = true;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%admin}}';
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['adminuser', 'required','message'=>'账号不能为空','on'=>['seekpass','login']],
            ['adminpass', 'required','message'=>'密码不能为空','on'=>['login']],
            ['adminemail', 'required','message'=>'电子邮箱不能为空','on'=>['seekpass']],
            ['adminemail', 'email','message'=>'电子邮箱格式不正确','on'=>['seekpass']],
            ['rememberMe', 'boolean','on'=>['login']],
            ['adminpass', 'validatePass','on'=>['login']],
            ['adminemail', 'validateEmail','on'=>['seekpass']]
        ];
    }
    public function validatePass(){
    	if (!$this->hasErrors()) {
    		$data = self::find()->where('adminuser = :user and adminpass = :pass',[":user" => $this->adminuser,":pass" => md5($this->adminpass)])->one();
    		if(is_null($data)){
    			$this->addError("adminpass","用户名或密码错误");
    		}
    	}
    }
    public function validateEmail(){

    	if (!$this->hasErrors()) {

    		$data = self::find()->where('adminuser = :user and adminemail = :email',[":user" => $this->adminuser,":email" => md5($this->adminemail)])->one();
    		if(is_null($data)){
    			
    			$this->addError("adminemail","管理员邮箱不匹配");
    		}
    	}
    }
    public function login($data){
    	$this->scenario = "login";
    	if($this->load($data) && $this->validate()){
    		$lifetime = $this->rememberMe ? 24*3600 : 0;
    		$session = Yii::$app->session;
    		session_set_cookie_params($lifetime);
    		$session['admin'] = [
    			'adminuser' => $this->adminuser,
    			'isLogin' => 1
    		];
    		$this->updateAll(['logintime'=>time(),'loginip'=>ip2long(Yii::$app->request->userIp)],'adminuser = :user',[':user'=>$this->adminuser]);
    		return (bool)$session['admin']['isLogin'];
    	}
    	return false;
    }
    public function seekPass($data){
    	$this->scenario = "seekpass";
    	if($this->load($data) && $this->validate()){
            Yii::$app->mailer->compose()
              ->setFrom('maxue_@126.com')
              ->setTo($data['Admin']['adminemail'])
              ->setSubject('慕课商城-找回密码')
              ->send();
            return true;
    	}
    	return false;
    }	
}