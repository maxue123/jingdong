<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
class Admin extends ActiveRecord{
    public $rememberMe = true;
	public $repass = "";
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
    public function attributeLabels()
    {
        return [
            'adminuser' => '管理员账号',
            'adminpass' => '管理员密码',
            'adminemail' => '管理员邮箱',
            'repass' => '确认密码',
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['adminuser', 'required','message'=>'账号不能为空','on'=>['seekpass','login','adminadd']],
            ['adminuser', 'unique','message'=>'管理员已被注册','on'=>['adminadd']],
            ['adminpass', 'required','message'=>'密码不能为空','on'=>['login','changepass','adminadd']],
            ['adminemail', 'required','message'=>'电子邮箱不能为空','on'=>['seekpass','adminadd']],
            ['adminemail', 'email','message'=>'电子邮箱格式不正确','on'=>['seekpass','adminadd']],
            ['adminemail', 'unique','message'=>'电子邮箱已被注册','on'=>['adminadd']],
            ['rememberMe', 'boolean','on'=>['login']],
            ['adminpass', 'validatePass','on'=>['login']],
            ['adminemail', 'validateEmail','on'=>['seekpass']],
            ['repass', 'required','message'=>'确认密码不能为空','on'=>['changepass','adminadd']],
            ['repass', 'compare','compareAttribute'=>'adminpass','message'=>'两次密码不一致','on'=>['changepass','adminadd']],
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

    		$data = self::find()->where('adminuser = :user and adminemail = :email',[":user" => $this->adminuser,":email" => $this->adminemail])->one();
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
            $time = time();
            $token = $this->createToken($data['Admin']['adminuser'],$time);
            Yii::$app->mailer->compose('passwordResetToken-html',['adminuser'=>$data['Admin']['adminuser'],'time'=>$time,'token'=>$token])
              ->setFrom('maxue_@126.com')
              ->setTo($data['Admin']['adminemail'])
              ->setSubject('慕课商城-找回密码')
              ->send();
            return true;
    	}
    	return false;
    }
    public function createToken($adminuser,$time){
        return md5(md5($adminuser).base64_encode(Yii::$app->request->userIp).md5($time));
    }
    public function changePass($data){
        $this->scenario = "changepass";
        if($this->load($data) && $this->validate()){
            return (bool)$this->updateAll(['adminpass'=>md5($this->adminpass)],'adminuser = :user',[':user'=>$data['Admin']['adminuser']]);
        }
        return false;
    }
    public function reg($data){
        $this->scenario = "adminadd";
        if($this->load($data) && $this->validate()){
            $this->adminpass = md5($data['Admin']['adminpass']);
            $this->createtime = time();
            if($this->save(false)){
                return true;
            }
        }
        return false;
    }
}