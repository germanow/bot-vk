<?php

namespace app\commands;

use yii\console\Controller;
use Yii;

class TestController extends Controller
{
   //Тестирование рабботы редис
    public function actionMyRedis($key, $value){
        $redis = Yii::$app->redis;
        $result = $redis->set($key, $value);
        $result = $redis->get($key);
        echo $result . PHP_EOL;
        
    }
}