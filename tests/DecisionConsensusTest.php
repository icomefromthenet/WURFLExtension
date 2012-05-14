<?php
namespace WURFLExtension\Tests;

use WURFLExtension\Container,
    WURFLExtension\Strategy\Consensus,
    PHPUnit_Framework_TestCase;

class DecisionConsensusTest extends PHPUnit_Framework_TestCase
{
    protected $backupGlobalsBlacklist = array('di_container');
    
    
    public function testNewDecision()
    {
        $decision = new Consensus();
        
        $this->assertInstanceOf('\WURFLExtension\StrategyInterface',$decision);
        
    }

    public function testAffirmative()
    {
        $decision = new Consensus();
        $data = array(true,true);
        $this->assertTrue($decision->decide($data));
        
        $data = array(false,true,true);
        $this->assertTrue($decision->decide($data));
       
        
        $data = array(true,true,false);
        $this->assertTrue($decision->decide($data));
       
    }
    
    public function testNegative()
    {
        $decision = new Consensus();
        $data = array(false,false);
        $this->assertFalse($decision->decide($data));
        
        $data = array(true,true,false,false,false);
        $this->assertFalse($decision->decide($data));
        
        $data = array(false,false,true);
        $this->assertFalse($decision->decide($data));
           
    }
    
    public function testTie()
    {
        $decision = new Consensus();
        $data = array(true,true,false,false);
        $this->assertTrue($decision->decide($data));
        
        $data = array();
        $this->assertFalse($decision->decide($data));
        
    }
    
    
}
/* End of File */