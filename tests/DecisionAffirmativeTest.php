<?php

class DecisionAffirmativeTest extends PHPUnit_Framework_TestCase
{

    public function testNewDecision()
    {
        $decision = new Kernel_Extension_Wurfl_Strategy_Affirmative();
        
        $this->assertInstanceOf('Kernel_Extension_Wurfl_StrategyInterface',$decision);
        
    }

    
    public function testAffirmative()
    {
        $decision = new Kernel_Extension_Wurfl_Strategy_Affirmative();
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
        $decision = new Kernel_Extension_Wurfl_Strategy_Affirmative();
        $data = array(false);
        $this->assertFalse($decision->decide($data));
        
        $data = array(false,false,false);
        $this->assertFalse($decision->decide($data));
        
    }

}
/* End of File */