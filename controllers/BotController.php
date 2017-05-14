<?php

namespace app\controllers;

use Yii;
use yii\rest\Controller;
use app\models\MessageJob;

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
        $request = Yii::$app->request->getBodyParams();
        switch ($request['type']){
            case 'confirmation':
                return static::TOKEN_CONFIRMATION;
            case 'message_new':
                Yii::$app->queue->push(new MessageJob([
                    'user_id' => $request['object']['user_id'],
                    'msg' => $request['object']['body'],
                ]));
                return 'ok';
            default:
                return 'ok';     
       }
        
    }
    
}
