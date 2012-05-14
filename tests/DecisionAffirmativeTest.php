<?php
namespace WURFLExtension\Tests;

use WURFLExtension\Container,
    WURFLExtension\Strategy\Affirmative,
    PHPUnit_Framework_TestCase;

class DecisionAffirmativeTest extends PHPUnit_Framework_TestCase
{

    protected $backupGlobalsBlacklist = array('di_container');
    


    public function testNewDecision()
    {
        $decision = new Affirmative();
        
        $this->assertInstanceOf('\WURFLExtension\StrategyInterface',$decision);
        
    }

    
    public function testAffirmative()
    {
        $decision = new Affirmative();
        $data = array(false,false,true);
        $this->assertTrue($decision->decide($data));
        
        $data = array(true);
        $this->assertTrue($decision->decide($data));
        
        $data = array(true,false,true);
        $this->assertTrue($decision->decide($data));
        
        $data = array(false,true);
        $this->assertTrue($decision->decide($data));
        
    }
    
    public function testNegative()
    {
        $decision = new Affirmative();
        $data = array(false);
        $this->assertFalse($decision->decide($data));
        
        $data = array(false,false,false);
        $this->assertFalse($decision->decide($data));
        
    }

}
/* End of File */