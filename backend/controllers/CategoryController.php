<?php
namespace backend\controllers;
use Yii;
use yii\web\Controller;
use common\models\Category;
/**
 * Index controller
 * 首页
 */
class CategoryController extends Controller
{
    public $layout = "layouts1";
    public function actionList(){
        return $this->render('list');   
    }
    public function actionAdd()
    {
        $model = new Category();
        $list = $model->getData();
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->add($post)) {
                Yii::$app->session->setFlash("info", "添加成功");
            }
        }
        return $this->render("add", ['list' => $list, 'model' => $model]);
    }
}