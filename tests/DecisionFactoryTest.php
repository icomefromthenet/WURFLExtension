<?php

class DecisionFactoryTest extends PHPUnit_Framework_TestCase
{

    public function testNewFactory()
    {
        $factory = new Kernel_Extension_Wurfl_DecisionFactory();
        
        $this->assertInstanceOf('Kernel_Extension_Wurfl_DecisionFactory',$factory);
        
    }
    
    /**
      * @expectedException Kernel_Extension_Wurfl_Exception
      * @expectedExceptionMessage Decision Manager Class Does not exist
      */
    public function testFactoryInvaildClass()
    {
        
       $factory = new Kernel_Extension_Wurfl_DecisionFactory();
       $class = "ReallyWrongClass";  
        
        $factory->create($class);
        
    }
    
    
    public function testFactoryValidClass()
    {
        $criteria = array();
        $class_name = 'Kernel_Extension_Wurfl_Decision_Test';
        $strategy = $this->getMockBuilder('Kernel_Extension_Wurfl_StrategyInterface')
                         ->setMethods(array('decide'))
                         ->getMock();
   
    
        $mock = $this->getMockBuilder('Kernel_Extension_Wurfl_DecisionManager')
                     ->setMockClassName($class_name)
                     ->disableOriginalConstructor()
                     ->getMock();
                     
        $mock::staticExpects($this->once())
              ->method('getStrategy')
              ->will($this->returnValue($strategy));
        
        $mock::staticExpects($this->once())
              ->method('getCriteria')
              ->will($this->returnValue($criteria));
        
       $factory = new Kernel_Extension_Wurfl_DecisionFactory();
        
       $factory->create($class_name);
        
    }


}
/* End of File */