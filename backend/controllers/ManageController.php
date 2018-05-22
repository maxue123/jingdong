<?php
namespace backend\controllers;
use Yii;
use yii\web\Controller;
use backend\models\Admin;
use yii\data\Pagination;
/**
 * Index controller
 * 首页
 */
class ManageController extends Controller
{
	public $layout = "layouts1";
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionManagers(){
    	$model = Admin::find();
    	$count = $model->count();
    	$pageSize = Yii::$app->params['pageSize']['manage'];
    	$pager = new Pagination(['totalCount'=>$count,'pageSize' => $pageSize]);
    	$managers = $model->offset($pager->offset)->limit($pager->limit)->all();
    	return $this->render('managers',['managers'=>$managers,'pager'=>$pager]);
    }
    public function actionReg(){
    	$model = new Admin;
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            if($model->reg($post)){
                Yii::$app->session->setFlash('info','管理员添加成功');
            }else{
                Yii::$app->session->setFlash('info','管理员添加失败');
            }          
        }
        $model->adminpass = '';
        $model->repass = '';
    	return $this->render('reg',['model'=>$model]);
    }
    public function actionDel(){
        $adminid = (int)Yii::$app->request->get("adminid");
        if(empty($adminid)){
            $this->redirect(['manage/managers']);
        }
        $model = new Admin;
        if($model->deleteAll('adminid = :id',[':id'=>$adminid])){
            Yii::$app->session->setFlash('info','删除成功');
            $this->redirect(['manage/managers']);
        }
    }
}