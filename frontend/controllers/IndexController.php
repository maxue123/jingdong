<?php
namespace frontend\controllers;
use Yii;
use yii\web\Controller;
/**
 * Index controller
 * 首页
 */
class IndexController extends Controller
{
	public $layout = "layouts1";
    public function actionIndex()
    {
    	var_dump('1111');die;
        return $this->render('index');
    }
    public function actionIndexl()
    {
    	var_dump('1111');die;
        return $this->render('index');
    }
}