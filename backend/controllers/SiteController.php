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
class SiteController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        //$this->redirect(array('/gakki/index'));
       // var_dump(Yii::$app->user->isGuest);

        if(!\Yii::$app->user->isGuest) {

            $this->redirect('/gakki/index')->send();
        }
        //return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {

        var_dump(Yii::$app->user->isGuest);
        echo 123;
        if (!\Yii::$app->user->isGuest) {


            return $this->goHome()->send();
        }


//        var_dump($_COOKIE);
        $model = new LoginForm();

        if ( Yii::$app->request->isPost) {
            if($model->load(Yii::$app->request->post()) && $model->login()){
                //Yii::$app->getSession()->setFlash('error',$model->errmsg);
                    echo 123;
                return $this->goBack()->send();
            }else{
                Yii::$app->getSession()->setFlash('error',$model->errmsg);
                return $this->render('login', [
                    'model' => $model,
                ]);
            }

         //   return $this->actionIndex();
        } else {
            $model->password = '';
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
