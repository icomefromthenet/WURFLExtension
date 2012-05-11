<?php

class DecisionUnanimousTest extends PHPUnit_Framework_TestCase
{
    
    public function testNewObject()
    {
        $decision = new Kernel_Extension_Wurfl_Strategy_Unanimous();    
        
        $this->assertInstanceOf('Kernel_Extension_Wurfl_StrategyInterface',$decision);
        
    }
    
    
    public function testAffirmative()
    {
        $decision = new Kernel_Extension_Wurfl_Strategy_Unanimous();    

        $data = array(true,true,true);
        $this->assertTrue($decision->decide($data));
    
    
        $data = array(true);
        $this->assertTrue($decision->decide($data));
        
    }
    
    public function testNegative()
    {
        $decision = new Kernel_Extension_Wurfl_Strategy_Unanimous();    
        $data = array(false);
        $this->assertFalse($decision->decide($data));
        
        $data = array(false,true,true);
        $this->assertFalse($decision->decide($data));
        
        $data = array(true,true,false);
        $this->assertFalse($decision->decide($data));
       
        $data = array();
        $this->assertFalse($decision->decide($data));
        
    }
    
    
}
/* End of File */