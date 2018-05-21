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
        //return $this->render('login',['model' => $model]);
        return $this->render('login',['model' => $model]);
    }
}