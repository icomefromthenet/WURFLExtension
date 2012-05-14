<?php
namespace WURFLExtension\Tests;

use WURFLExtension\Container,
    WURFLExtension\Strategy\Unanimous,
    PHPUnit_Framework_TestCase;

class DecisionUnanimousTest extends PHPUnit_Framework_TestCase
{
    
    protected $backupGlobalsBlacklist = array('di_container');
    
    
    public function testNewObject()
    {
        $decision = new Unanimous();    
        
        $this->assertInstanceOf('WURFLExtension\StrategyInterface',$decision);
        
    }
    
    
    public function testAffirmative()
    {
        $decision = new Unanimous();    

        $data = array(true,true,true);
        $this->assertTrue($decision->decide($data));
    
    
        $data = array(true);
        $this->assertTrue($decision->decide($data));
        
    }
    
    public function testNegative()
    {
        $decision = new Unanimous();    
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