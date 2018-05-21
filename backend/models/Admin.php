<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
class Admin extends ActiveRecord{
	public $rememberMe = true;
	public static function tableName(){
		return "{{shop_admin}}";
	}
}