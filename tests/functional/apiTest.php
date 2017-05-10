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
        $json = ['type' => 'confirmation', 'group_id' => '146639882'];
        $token_confirmation = '6e6e3549';
        $this->tester->sendGET('/bot/callback', $json);
        $this->tester->seeResponseCodeIs(200);
        $this->tester->seeResponseIsJson();
        $this->tester->seeResponseContains($token_confirmation);
        
    }
    
    /** @test */
    public function otherResponseIsOk()
    {
        $json = ['type' => 'notConfirmation', 'group_id' => '146639882'];
        $this->tester->sendGET('/bot/callback', $json);
        $this->tester->seeResponseCodeIs(200);
        $this->tester->seeResponseIsJson();
        $this->tester->seeResponseContains('ok');
        
    }
}