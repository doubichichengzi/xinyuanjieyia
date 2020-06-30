<?php
namespace backend\controllers;

use common\components\BaseController;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * Site controller
 */
class GakkiController extends BaseController
{
    /**
     *
     */
    //verification_token

    public $enableCsrfValidation = false;

    public function actionIndex(){
        echo 123;
        exit;
        $isState = Yii::$app->user->identity;
        var_dump(Yii::$app->user->isGuest);
        var_dump(Yii::$app->user->identity);

        $data = Yii::$app->db->createCommand("
        select * from pre_user
        ")->queryAll();
        print_r($data);
    }
}