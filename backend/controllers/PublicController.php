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
    	var_dump('1111111');die;
    	$model = new Admin;
        return $this->render('login',['model' => $model]);
    }
}