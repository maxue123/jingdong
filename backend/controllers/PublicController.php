<?php
namespace backend\controllers;
use Yii;
use yii\web\Controller;
use backend\models\Admin;
/**
 * Index controller
 * 首页
 */
class PublicController extends Controller
{
    public function actionLogin()
    {
    	$this->layout = false;

    	$model = new Admin;
    	if(Yii::$app->request->isPost){
    		$post = Yii::$app->request->post();
    		if($model->login($post)){
    			$this->redirect(['index/index']);
    			Yii::$app->end();
    		}
    	}
        
        return $this->render('login',['model' => $model]);
    }
    public function actionLogout(){
    	Yii::$app->session->removeAll();
    	if(!isset(Yii::$app->session['admin']['isLogin'])){
    		$this->redirect(['public/login']);
    		Yii::$app->end();
    	}
    	$this->goback();
    }
    /**
     * [actionSeekpassword description]
     * @return 找回密码
     * @return [type] [description]
     */
    public function actionSeekpassword(){
    	$this->layout = false;
    	$model = new Admin;
    	if(Yii::$app->request->isPost){
    		$post = Yii::$app->request->post();
    		if($model->seekPass($post)){

    			Yii::$app->session->setFlash('info','电子邮件发送成功');
    		}    		
    	}
		return $this->render('seekpassword',['model' => $model]);
    }
}