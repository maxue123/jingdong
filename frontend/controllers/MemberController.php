<?php
namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use common\models\User;
/**
 * Index controller
 * 商品分页
 */
class MemberController extends Controller
{
	public $layout = "layouts2";
	public function actionAuth()
    {
    	$model = new User();
    	if(Yii::$app->request->isPost){
    		$post = Yii::$app->request->post();
    		if($model->login($post)){
    			Yii::$app->session->setFlash('info','登陆成功');
    			return $this->goBack(Yii::$app->request->referrer);
    		}    		
    	}
        return $this->render('auth',['model'=>$model]);
    }
    public function actionReg(){
    	$model = new User();
    	if(Yii::$app->request->isPost){
    		$post = Yii::$app->request->post();
    		if($model->regByMail($post)){
    			Yii::$app->session->setFlash('info','电子邮件注册成功');
    		}    		
    	}
    	return $this->render('auth',['model'=>$model]);
    }
}