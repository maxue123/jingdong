<?php
namespace frontend\controllers;
use Yii;
use yii\web\Controller;
/**
 * Index controller
 * 商品分页
 */
class CartController extends Controller
{
	public $layout = "layouts1";
	public function actionIndex()
    {
        return $this->render('index');
    }
}