<?php


class apiTest extends \Codeception\Test\Unit
{
    /**
     * @var \FunctionalTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    /** @test */
    public function tokenConfirmation()
    {
        $secretKey = require(Yii::getAlias('@app') . '/config/secretKey.php');
        $json = ['type' => 'confirmation', 'group_id' => '146639882', 'secret' => $secretKey];
        $token_confirmation = '6e6e3549';
        $this->tester->sendPOST('/bot/callback', $json);
        $this->tester->seeResponseCodeIs(200);
        $this->tester->seeResponseContains($token_confirmation);
        
    }
    
    /** @test */
    public function otherResponseIsOk()
    {
        $secretKey = require(Yii::getAlias('@app') . '/config/secretKey.php');
        $json = ['type' => 'notConfirmation', 'group_id' => '146639882', 'secret' => $secretKey];
        $this->tester->sendPOST('/bot/callback', $json);
        $this->tester->seeResponseCodeIs(200);
        $this->tester->seeResponseContains('ok');
        
    }
    
    /** @test */
    public function secretKey()
    {
        $json = ['type' => 'Confirmation'];
        $this->tester->sendPOST('/bot/callback', $json);
        $this->tester->seeResponseCodeIs(403);    
    }
}