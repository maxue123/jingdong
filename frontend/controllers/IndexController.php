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
	public $layout = false;
    public function actionIndex()
    {
    	public $layout = false;
        return $this->render('index');
    }
}