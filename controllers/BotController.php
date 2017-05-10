<?php

namespace app\controllers;

use Yii;
use yii\rest\Controller;


class BotController extends Controller
{
    
    const TOKEN_CONFIRMATION = '6e6e3549';
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\ContentNegotiator',
                'only' => ['callback'],
                'formats' => [
                    'application/json' => Yii::$app->response::FORMAT_JSON,
                ],
            ]
        ];
    }


    public function actionCallback()
    {
        $type = Yii::$app->request->get('type');
        switch ($type){
            case 'confirmation':
                return static::TOKEN_CONFIRMATION;
            default:
                return 'ok';
                
           
       }
        
    }
    
}
