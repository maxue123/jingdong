<?php
namespace frontend\controllers;
use Yii;
use yii\web\Controller;
/**
 * Index controller
 * 商品分页
 */
class OrderController extends Controller
{
	public function actionIndex(){
		public $layout = "layouts2";
		return $this->render('index');
	}
	public function actionCheck()
    {
    	$this->layout = "layouts1";
        return $this->render('check');
    }
}