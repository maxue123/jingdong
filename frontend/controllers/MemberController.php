<?php
namespace frontend\controllers;
use Yii;
use yii\web\Controller;
/**
 * Index controller
 * 商品分页
 */
class MemberController extends Controller
{
	public $layout = false;
	public function actionAuth()
    {
        return $this->render('auth');
    }
}