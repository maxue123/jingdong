<?php
namespace frontend\controllers;
use Yii;
use yii\web\Controller;
/**
 * Index controller
 * 商品分页
 */
class ProductController extends Controller
{
	public $layout = "layouts2";
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionDetail()
    {
    	return $this->render('detail');
    }
}