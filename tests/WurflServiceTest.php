<?php
include_once (realpath(__DIR__ .'/../../src/Vendor/TeraWurfl/TeraWurfl.php'));


class MockSession extends Zend_Session_Namespace
{

    public $data;

    public $checked;
    
    
    public function __get($function)
    {
        return $this->$function;
    }
    
    public function __set($key,$value)
    {
        $this->$key = $value;
    }
    
}


class WurflServiceTest  extends PHPUnit_Framework_TestCase
{
    
    public function testServiceSearch()
    {
        
        $ua = "Mozilla/5.0 (Windows; U; Windows NT 6.1; zh-HK) AppleWebKit/533.18.1 (KHTML, like Gecko) Version/5.0.2 Safari/533.18.5";
        $data = array('display' => array('screen_width' => 100));
        
        # setup mock wurfl instance
        $instance = $this->getMockWurfl();
       
        $instance->expects($this->once())
                 ->method('parse')
                 ->with($this->equalTo($ua))
                 ->will($this->returnValue($data));
       
        # setup mock session
        $session = $this->getMockSession();
       
        # setup the Resolver
        $resolver = $this->getMockResolver();
        
        $service = new Kernel_Extension_Wurfl_Service($resolver,$session,$instance);
        
        # run the test
        
        $capability = $service->search($ua);
        
        # did the search method return capability
        $this->assertInstanceOf('Kernel_Extension_Wurfl_Capability',$capability);
        $this->assertSame($data,$capability->toArray());
        
        # test the capability struct was pushed into session
        
        $this->assertSame($session->data,$capability);
        
    }
    
    
    public function testLock()
    {
        $ua = "Mozilla/5.0 (Windows; U; Windows NT 6.1; zh-HK) AppleWebKit/533.18.1 (KHTML, like Gecko) Version/5.0.2 Safari/533.18.5";
        $data = array('display' => array('screen_width' => 100));
        
        # setup mock wurfl instance
        $instance = $this->getMockWurfl();
       
        # setup mock session
        $session = $this->getMockSession();
       
        # setup the Resolver
        $resolver = $this->getMockResolver();
        
        $service = new Kernel_Extension_Wurfl_Service($resolver,$session,$instance);
    
        $this->assertFalse($service->isLocked());
    
        $service->lock();
        
        $this->assertTrue($service->isLocked());
    
        $service->unlock();
        
        $this->assertFalse($service->isLocked());
   
    }
    
   
    public function testRun()
    {
        $ua = "Mozilla/5.0 (Windows; U; Windows NT 6.1; zh-HK) AppleWebKit/533.18.1 (KHTML, like Gecko) Version/5.0.2 Safari/533.18.5";
        $data = array('display' => array('screen_width' => 100));
        $referer = "wurfl";
        
        # setup mock wurfl instance
        $instance = $this->getMockWurfl();
       
        $instance->expects($this->once())
                 ->method('parse')
                 ->with($this->equalTo($ua))
                 ->will($this->returnValue($data));
       
        # setup mock session
        $session = $this->getMockSession();
       
        # setup the Resolver
        $resolver = $this->getMockResolver();
        $resolver->expects($this->once())
                 ->method('resolve')
                 ->with($this->equalTo($data),$this->equalTo($referer));
           
        $service = new Kernel_Extension_Wurfl_Service($resolver,$session,$instance);
        
        $has_run = $service->run($referer,$ua);
        $this->assertTrue($has_run);
        $this->assertTrue($service->isLocked());
        $run_again =  $service->run($referer,$ua);
        $this->assertFalse($run_again);
    }
   
    
    //  -------------------------------------------------------------------------
    
    
    protected function getMockWurfl()
    {
            return $this->getMockBuilder('Kernel_Extension_Wurfl_Instance')
             ->disableOriginalConstructor()
             ->setMethods(array('parse'))
             ->getMock();

    }
    
    protected function getMockSession()
    {
      return $this->getMockBuilder('MockSession')
             ->disableOriginalConstructor()
             ->getMock();
    }
    
    protected function getMockResolver()
    {
        return $this->getMockBuilder('Kernel_Extension_Wurfl_Resolver')
             ->disableOriginalConstructor()
             ->getMock();
    }

    //  -------------------------------------------------------------------------
}
/* End of File */