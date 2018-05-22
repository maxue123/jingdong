<?php
namespace backend\controllers;
use Yii;
use yii\web\Controller;
use common\models\User;
use common\models\Profile;
use yii\data\Pagination;
/**
 * Index controller
 * 首页
 */
class UserController extends Controller
{
	public $layout = "layouts1";
    public function actionUsers()
    {
    	$model = User::find()->joinWith('profile');
    	$count = $model->count();
    	$pageSize = Yii::$app->params['pageSize']['manage'];
    	$pager = new Pagination(['totalCount'=>$count,'pageSize' => $pageSize]);
    	$users = $model->offset($pager->offset)->limit($pager->limit)->all();
    	return $this->render('users',['users'=>$users,'pager'=>$pager]);
    }
    public function actionReg()
    {
        $model= new User;
        if(Yii::$app->request->isPost){
    		$post = Yii::$app->request->post();
    		if($model->reg($post)){

    			Yii::$app->session->setFlash('info','注册成功');
    		}    		
    	}
    	$model->repass = '';
    	$model->userpass = '';
        return $this->render('reg',['model'=>$model]);
    }
}