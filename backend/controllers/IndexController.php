<?php
namespace backend\controllers;
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
        return $this->render('index');
    }
}