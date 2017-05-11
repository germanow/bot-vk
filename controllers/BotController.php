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
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['callback'],
                'rules' => [
                    [
                        'allow' => true,
                        //Проверка что запрос пришел от серверов vk
                        'matchCallback' => function($rule, $action){
                            $request = Yii::$app->request->getBodyParams();
                            if(isset($request['secret'])){
                                $secret = require(Yii::getAlias('@app') . '/config/secretKey.php');
                                if($request['secret'] == $secret){
                                    return True;
                                }
                            }
                        }
                    ]
                ],
                'denyCallback' => function($rule, $action){
                    throw new \yii\web\HttpException(403);
                }
            ],
        ];
    }


    public function actionCallback()
    {
        $api = new \ATehnix\VkClient\Client(); 
        $token = require(Yii::getAlias('@app') . '/config/token.php');
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
