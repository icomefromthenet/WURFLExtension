<?php
namespace WURFLExtension\Tests;

use WURFLExtension\Decision\Factory,
    PHPUnit_Framework_TestCase;

class DecisionFactoryTest extends PHPUnit_Framework_TestCase
{
    
    protected $backupGlobalsBlacklist = array('di_container');
    

    public function testNewFactory()
    {
        $factory = new Factory();
        $this->assertInstanceOf('\WURFLExtension\Decision\Factory',$factory);
    }
    
    /**
      * @expectedException \WURFLExtension\Exception
      * @expectedExceptionMessage Decision Manager Class Does not exist
      */
    public function testFactoryInvaildClass()
    {
        
       $factory = new Factory();
       $class = "ReallyWrongClass";  
       $factory->create($class,function(){});
        
    }
    
    
    public function testFactoryValidClass()
    {
        $criteria = array();
        $class_name = 'MockDecision';
        
        $strategy = $this->getMockBuilder('\WURFLExtension\StrategyInterface')
                         ->setMethods(array('decide'))
                         ->getMock();
   
    
        $mock = $this->getMockBuilder('\WURFLExtension\Decision\Decision')
                     ->setMockClassName($class_name)
                     ->disableOriginalConstructor()
                     ->getMock();
                     
        $mock::staticExpects($this->once())
              ->method('getStrategy')
              ->will($this->returnValue($strategy));
        
        $mock::staticExpects($this->once())
              ->method('getCriteria')
              ->will($this->returnValue($criteria));
        
       $factory = new Factory();
        
       $factory->create($class_name,function(){});
        
    }


}
/* End of File */