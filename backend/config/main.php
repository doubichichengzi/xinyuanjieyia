<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);
$db = require(__DIR__ . '/../../common/config/db.php');
$config= [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    //'defaultRoute' => 'site/index',

    'modules' => [],
    /*'modules' => [
        'debug'=>[
            'class'=>'yii\debug\Module',
            'allowedIPs'=>['127.0.0.1']
        ],
        'setting' => [
            'class' => 'backend\modules\setting\SettingModule',
        ],
        'forum' => [
            'class' => 'backend\modules\forum\ForumModule',
            'aliases' => [
                '@forum_icon' => '@web/uploads/forum/icon/', //图标上传路径
                '@avatar' => '@web/uploads/user/avatar/',
                '@photo' => '@web/uploads/blog/photo/'
            ],
        ],
        'rbac' => [
            'class' => 'backend\modules\rbac\Module',
            'layout' => 'left-menu',
        ],
        'editor' => [
            'class' => 'backend\modules\editor\Module',

        ],
        'movietools' => [
            'class' => 'backend\modules\movietools\Module',
        ],
        'topuser' => [
            'class' => 'backend\modules\topuser\Module',
        ],
        'topcdbmobile' => [
            'class' => 'backend\modules\topcdbmobile\Module',
        ],
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
            // enter optional module parameters below - only if you need to
            // use your own export download action or custom translation
            // message source
            // 'downloadAction' => 'gridview/export/download',
            // 'i18n' => []
        ],
        'dynagrid' =>  [
            'class' => 'kartik\dynagrid\Module'
        ],
    ],*/
    'components' => [
        'db' => $db,
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
//        "view"=>[
//            'theme' => [
//                'pathMap' => [
//                    '@app/views' => '@app/themes/newv2',
//                //    '@app/views_old' => '@app/views',
//                    //      '@app/modules' => '@app/themes/basic/modules',
//                ],
//            ],
//        ],
        /*
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' =>false,//这句一定有，false发送邮件，true只是生成邮件在runtime文件夹下，不发邮件
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                //'host' => 'smtp.163.com',  //每种邮箱的host配置不一样
                'host' => 'smtp.exmail.qq.com',  //每种邮箱的host配置不一样
                'username' => 'top_verify@topcdb.com',
                'password' => 'Top123456',
                // 'port' => '25',  //端口
                'port' => '465',  //端口
                // 'encryption' => 'tls',
                'encryption' => 'ssl',  //貌似是加密方式,没查到
                // 'useFileTransport' => true,

            ],
            'messageConfig'=>[
                'charset'=>'UTF-8',
                'from'=>['top_verify@topcdb.com'=>'拓普世纪信息咨询有限公司']
            ],
        ],*/
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
*/
        'urlManager' => [
            'enablePrettyUrl' => true,  //美化url==ture
            //'enableStrictParsing' => true,  //启用严格解析
            'showScriptName' => false,   //隐藏index.php
            'rules' => [
                ['class' => 'yii\rest\UrlRule','controller' => 'user', 'pluralize'=>FALSE],
               // '<controller:(cinema)>/<action:(main-rowpiece)>/<id:\w+>/<vtype:\w+>' => '<controller>/<action>',
            ],

        ]

    ],
    'params' => $params,
];
return $config;