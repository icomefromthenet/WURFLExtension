<?php

class DecisionConsensusTest extends PHPUnit_Framework_TestCase
{
    public function testNewDecision()
    {
        $decision = new Kernel_Extension_Wurfl_Strategy_Consensus();
        
        $this->assertInstanceOf('Kernel_Extension_Wurfl_StrategyInterface',$decision);
        
    }

    public function testAffirmative()
    {
        $decision = new Kernel_Extension_Wurfl_Strategy_Consensus();
        $data = array(true,true);
        $this->assertTrue($decision->decide($data));
        
        $data = array(false,true,true);
        $this->assertTrue($decision->decide($data));
       
        
        $data = array(true,true,false);
        $this->assertTrue($decision->decide($data));
       
    }
    
    public function testNegative()
    {
        $decision = new Kernel_Extension_Wurfl_Strategy_Consensus();
        $data = array(false,false);
        $this->assertFalse($decision->decide($data));
        
        $data = array(true,true,false,false,false);
        $this->assertFalse($decision->decide($data));
        
        $data = array(false,false,true);
        $this->assertFalse($decision->decide($data));
           
    }
    
    public function testTie()
    {
        $decision = new Kernel_Extension_Wurfl_Strategy_Consensus();
        $data = array(true,true,false,false);
        $this->assertTrue($decision->decide($data));
        
        $data = array();
        $this->assertFalse($decision->decide($data));
        
    }
    
    
}
/* End of File */