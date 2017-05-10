<?php

namespace app\controllers;

use Yii;
use yii\rest\Controller;


class BotController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
        ];
    }


    public function actionIndex()
    {
       return 'Hello world';
    }
    
}
