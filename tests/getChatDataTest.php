<?php
use PHPUnit\Framework\TestCase;
require_once getcwd().'../app/models/User_model.php';
class getChatDataTest extends TestCase{
    public function testGetChatData(){
        $model=new User_model;
        
        
            $usrId=711488216;
            $wrongUsrId=1529918617;
        
        $expectedNamdep="Raya";
        $getChat = $model->getChatData($usrId);
        
        $this->assertEquals($expectedNamdep,$getChat['namdep']);
    }
}