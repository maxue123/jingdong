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
    public $loginname;
    public $rememberMe = true;
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
            ['loginname', 'required', 'message' => '登录用户名不能为空', 'on' => ['login']],
            ['username', 'required','message'=>'用户账号不能为空','on'=>['reg']],
            ['username', 'unique','message'=>'用户账号已被注册','on'=>['reg']],
            ['userpass', 'required','message'=>'用户密码不能为空','on'=>['reg','regbymail','login']],
            ['userpass', 'validatePass', 'on' => ['login']],
            ['useremail', 'required','message'=>'电子邮箱不能为空','on'=>['reg','regbymail']],
            ['useremail', 'email','message'=>'电子邮箱格式不正确','on'=>['reg','regbymail']],
            ['useremail', 'unique','message'=>'电子邮箱已被注册','on'=>['reg','regbymail']],
            ['repass', 'required','message'=>'确认密码不能为空','on'=>['reg']],
            ['repass', 'compare','compareAttribute'=>'userpass','message'=>'两次密码不一致','on'=>['reg']],
            [['username', 'userpass'], 'unique', 'targetAttribute' => ['username', 'userpass']],
            [['useremail', 'userpass'], 'unique', 'targetAttribute' => ['useremail', 'userpass']],
        ];
    }
    public function validatePass()
    {
        if (!$this->hasErrors()) {
            $loginname = "username";
            if (preg_match('/@/', $this->loginname)) {
                $loginname = "useremail";
            }
            $data = self::find()->where($loginname.' = :loginname and userpass = :pass', [':loginname' => $this->loginname, ':pass' => md5($this->userpass)])->one();
            if (is_null($data)) {
                $this->addError("userpass", "用户名或者密码错误");
            }
        }
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
    public function reg($data, $scenario = 'reg'){
        $this->scenario = $scenario;
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
    public function regByMail($data){
        $this->scenario = "regbymail";
        $data['User']['username'] = 'ykz'.uniqid();
        $data['User']['userpass'] = uniqid();
        if($this->load($data) && $this->validate()){
            $mailer = Yii::$app->mailer->compose('cerateuser',['username'=>$data['User']['username'],'userpass'=>$data['User']['userpass']])
              ->setFrom('maxue_@126.com')
              ->setTo($data['User']['useremail'])
              ->setSubject('慕课商城-注册邮箱');
            if($mailer->send() && $this->reg($data,'regbymail')){
                return true;
            }
        }
        return false;
    }
    public function login($data){
        $this->scenario = "login";
        if($this->load($data) && $this->validate()){
            $lifetime = $this->rememberMe ? 24*3600 : 0;
            $session = Yii::$app->session;
            session_set_cookie_params($lifetime);
            $session['loginname'] = $this->loginname;
            $session['isLogin'] = 1;
            return (bool)$session['isLogin'];
        }
        return false;
    }
}
