<?php
////////////////////
// This file contains the database access information.  Kd34n#$bhd3@
// This file is needed to establish a connection to MySQL d9a81515-d5fe

/*
if(isset($_SERVER['SERVER_NAME'])&&($_SERVER['SERVER_NAME']=='localhost'||$_SERVER['SERVER_NAME']=='localhost4')){
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=rm-2ze09s3m26j8i4277o.mysql.rds.aliyuncs.com;dbname=spider',
        'username' => 'root',
        'password' => 'Kd34n#$bhd3',
        'attributes' => [
            // use a smaller connection timeout
            PDO::ATTR_TIMEOUT => 10,
        ],
        'tablePrefix' => 'pre_',
        'emulatePrepare'=>true,
        'enableSchemaCache' => false //No need to modify
    ];
}elseif(!isset($_SERVER['SERVER_NAME'])){
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=rm-2ze09s3m26j8i4277.mysql.rds.aliyuncs.com;dbname=spider',
        'username' => 'root',
        'password' => 'Kd34n#$bhd3',
        'attributes' => [
            // use a smaller connection timeout
            PDO::ATTR_TIMEOUT => 10,
        ],
        'tablePrefix' => 'pre_',
        'enableSchemaCache' => false //No need to modify
    ];
}else{
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=rm-2ze09s3m26j8i4277.mysql.rds.aliyuncs.com;dbname=spider',
        'username' => 'root',
        'password' => 'Kd34n#$bhd3',
        'tablePrefix' => 'pre_',
        'enableSchemaCache' => false //No need to modify
    ];
}*/
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=qxc',
    'username' => 'root',
    'password' => 'root',
    'tablePrefix' => 'pre_',
    'enableSchemaCache' => false //No need to modify
];