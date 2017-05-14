<?php

namespace app\models;

use Yii;
use yii\base\Object;


class MessageJob extends Object implements \zhuravljov\yii\queue\Job
{
    public $user_id;
    public $msg;
            
    public function execute($queue)
    {
        $api = new \ATehnix\VkClient\Client(); 
        $token = require(Yii::getAlias('@app') . '/config/token.php');
        $api->setDefaultToken($token);
        
        $api->request('messages.send', ['user_id' => $this->user_id, 'message' => $this->msg]);
    }
}