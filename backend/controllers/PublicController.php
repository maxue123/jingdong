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
    	var_dump($model);
    	var_dump('22233');
    	die;
        return $this->render('login',['model' => $model]);
    }
}