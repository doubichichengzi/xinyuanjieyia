<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * Site controller
 */
class GakkiController extends SiteController
{
    /**
     *
     */
    //verification_token
    public $enableCsrfValidation = false;

    public function actionIndex(){
        $isState = Yii::$app->user->identity;
        var_dump(Yii::$app->user->isGuest);
        var_dump($isState);
        $data = Yii::$app->db->createCommand("
        select * from pre_user
        ")->queryAll();
        print_r($data);
    }
}