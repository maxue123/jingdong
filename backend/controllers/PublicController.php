<?php
namespace backend\controllers;
use Yii;
use yii\web\Controller;
/**
 * Index controller
 * 首页
 */
class PublicController extends Controller
{
    public function actionLogin()
    {
        return $this->render('login');
    }
}