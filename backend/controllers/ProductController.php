<?php
namespace backend\controllers;
use Yii;
use yii\web\Controller;
use common\models\Category;
use common\models\Product;
/**
 * Index controller
 * 首页
 */
class ProductController extends Controller
{
    public $layout = "layouts1";
    public function actionList(){
        return $this->render('list');   
    }
    public function actionAdd(){
    	$model = new Product();
    	$cateModel= new Category();
    	$list = $cateModel->getData();
    	unset($list[0]);
    	if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $pics = $this->upload();
            if(!$pics){
            	$model->addError('cover','封面不能为空');
            }    
        }
        return $this->render('add',['opts'=>$list,'model'=>$model]);   
    }
    private function upload(){
    	if($_FILES['Product']['error']['cover'] > 0){
    		return false;
    	}
    }
}