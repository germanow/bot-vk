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
//            [
//                'class' => 'yii\filters\ContentNegotiator',
//                'only' => ['callback'],
//            ]
        ];
    }


    public function actionCallback()
    {
        $api = new \ATehnix\VkClient\Client();
        $token = require(__DIR__ . '/../config/token.php');
        $api->setDefaultToken($token);
        
        $request = Yii::$app->request->getBodyParams();
        switch ($request['type']){
            case 'confirmation':
                return static::TOKEN_CONFIRMATION;
            case 'message_new':
                echo 'ok';
                $msg = $request['object'];
                $reply = 'Привет!Я бот, и это всё, что я умею отвечать('; 
                $response = $api->request('messages.send', ['user_id' => $msg['user_id'], 'message' => $reply]);
                break;
            default:
                return 'ok';
                
                
           
       }
        
    }
    
}
