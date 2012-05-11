<?php

class WurflBootTest extends PHPUnit_Framework_TestCase
{
    
    public function testNewBoot()
    {
        $boot = new Kernel_Extension_Wurfl_Bootstrap();
        
        $this->assertInstanceOf('Kernel_Bootstrap_BootInterface',$boot);
        $this->assertInstanceOf('Kernel_Routing_RouteInterface',$boot);
        
    }
    
    
    public function testProperties()
    {
        # Test Session
        $boot = new Kernel_Extension_Wurfl_Bootstrap();
        $session = $this->getMockSession();
        $boot->setSession($session);
        $this->assertSame($boot->getSession(),$session);
        
        # Test Decision Factory
        $factory = $this->getMockDecisionFactory();
        $boot->setDecisionFactory($factory);
        $this->assertSame($boot->getDecisionFactory(),$factory);
            
        # Test Config
        $config = $this->getMockConfig();
        $boot->setConfig($config);    
        $this->assertSame($boot->getConfig(),$config);
            
        # Test Wurfl
        $wurfl = $this->getMockWurflInstance();
        $boot->setWurfl($wurfl);
        $this->assertSame($boot->getWurfl(),$wurfl);
        
    }
    
    public function testCreateResolverNoManagers()
    {
        $boot = new Kernel_Extension_Wurfl_Bootstrap();
        
        $factory = $this->getMockDecisionFactory();
        $boot->setDecisionFactory($factory);
            
        # Test Config
        $config = $this->getMockConfig();
        $boot->setConfig($config);    
        
        $config->expects($this->once())
               ->method('get')
               ->with($this->equalTo('theme.wurfl_decision_managers'), $this->equalTo(null))
               ->will($this->returnValue(array()));
        
        $boot->createResolver();        
        
    }
    
    public function testCreateResolver()
    {
        $boot = new Kernel_Extension_Wurfl_Bootstrap();
        
        $class_name = 'Kernel_Extension_Wurfl_Decision_TestB';
        $decision = $this->getMockDecision($class_name);
        
        $factory = $this->getMockDecisionFactory();
        $boot->setDecisionFactory($factory);
        
        $factory->expects($this->once())
                ->method('create')
                ->with($this->equalTo($class_name))
                ->will($this->returnValue($decision));
            
        # Test Config
        $config = $this->getMockConfig();
        $boot->setConfig($config);    
        
        $config->expects($this->once())
               ->method('get')
               ->with($this->equalTo('theme.wurfl_decision_managers'), $this->equalTo(null))
               ->will($this->returnValue(array($class_name)));
        
        $result = $boot->createResolver();  
        
        # test the resolver is returned
        $this->assertInstanceOf('Kernel_Extension_Wurfl_Resolver',$result);
        
        
    }
    
    public function testCreateResolverNoConfig()
    {
        $boot = new Kernel_Extension_Wurfl_Bootstrap();
            
        # Test Config
        $config = $this->getMockConfig();
        $boot->setConfig($config);    
        
        $config->expects($this->once())
               ->method('get')
               ->with($this->equalTo('theme.wurfl_decision_managers'), $this->equalTo(null))
               ->will($this->returnValue(null));
        
        $result = $boot->createResolver();  
        
    }
    
    
    public function testBoot()
    {
        
        $class_name = 'Kernel_Extension_Wurfl_Decision_TestC';
        
        # Test Session
        $boot = new Kernel_Extension_Wurfl_Bootstrap();
        $decision = $this->getMockDecision($class_name);
        $session = $this->getMockSession();
        $boot->setSession($session);
        
        # Test Decision Factory
        $factory = $this->getMockDecisionFactory();
        $boot->setDecisionFactory($factory);
        
        $factory->expects($this->once())
                ->method('create')
                ->with($this->equalTo($class_name))
                ->will($this->returnValue($decision));

            
        # Test Config
        $config = $this->getMockConfig();
        $boot->setConfig($config);
        
         $config->expects($this->once())
               ->method('get')
               ->with($this->equalTo('theme.wurfl_decision_managers'), $this->equalTo(null))
               ->will($this->returnValue(array($class_name)));
        
            
        # Test Wurfl
        $wurfl = $this->getMockWurflInstance();
        $boot->setWurfl($wurfl);
        

        $this->assertInstanceOf('Kernel_Extension_Wurfl_Service',$boot->boot());        
        
    }
    
    
    //  ----------------------------------------------------------------------------
    # Get Mocks
    
    protected function getMockSession()
    {
        return $this->getMockBuilder('Zend_Session_Namespace')
                    ->disableOriginalConstructor()
                    ->setMethods(array('__get','__set'))
                    ->getMock();
        
    }
    
    protected function getMockConfig()
    {
        return $this->getMockBuilder('Kernel_Config')
                    ->disableOriginalConstructor()
                    ->setMethods(array('get'))
                    ->getMock();
        
    }
    
    protected function getMockWurflInstance()
    {
        return $this->getMockBuilder('Kernel_Extension_Wurfl_Instance')
                    ->setMethods(array('parse'))
                    ->disableOriginalConstructor()
                    ->getMock();
        
    }
    
    protected function getMockDecisionFactory()
    {
        return $this->getMockBuilder('Kernel_Extension_Wurfl_DecisionFactory')
                    ->setMethods(array('create'))
                    ->getMock();
    }
    
    protected function getMockDecision($class_name = 'Kernel_Extension_Wurfl_Decision_Test')
    {
        $criteria = array();
        
        $strategy = $this->getMockBuilder('Kernel_Extension_Wurfl_StrategyInterface')
                         ->setMethods(array('decide'))
                         ->getMock();
   
    
        $mock = $this->getMockBuilder('Kernel_Extension_Wurfl_DecisionManager')
                     ->setMockClassName($class_name)
                     ->disableOriginalConstructor()
                     ->getMock();
        /*                     
        $mock::staticExpects($this->once())
              ->method('getStrategy')
              ->will($this->returnValue($strategy));
        
        $mock::staticExpects($this->once())
              ->method('getCriteria')
              ->will($this->returnValue($criteria));
        */      
        return $mock;      
    }
    
    //  ----------------------------------------------------------------------------
}
/* End of File */