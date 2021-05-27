<?php
namespace yii\web {
    define('YII_ENV', 'test');
    defined('YII_DEBUG') or define('YII_DEBUG', true);

    require_once __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
    require __DIR__ .'/../vendor/autoload.php';

    function move_uploaded_file($from, $to) {
        rename($from, $to);
    }
    function is_uploaded_file($file) {
        return true;
    }

}