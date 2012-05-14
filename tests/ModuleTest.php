<?php
namespace WURFLExtension\Tests;

use PHPUnit_Framework_TestCase,
    WURFLExtension\Container,
    WURFLExtension\VoterInterface,
    WURFLExtension\StrategyInterface,
    WURFLExtension\Decision\Resolver,
    WURFLExtension\Decision\Decision;

class ModuleTest  extends PHPUnit_Framework_TestCase
{
    
    
    protected $backupGlobalsBlacklist = array('di_container');
    
    /**
      *  @var /WURFLExtension/Container
      */
    protected $di;
    

    public function setUp()
    {
        $this->di = new Container();
    }
    
    public function testSearch()
    {
        
        $ua = "Mozilla/5.0 (Windows; U; Windows NT 6.1; zh-HK) AppleWebKit/533.18.1 (KHTML, like Gecko) Version/5.0.2 Safari/533.18.5";
        $data = array('display' => array('screen_width' => 100));
        
        # setup mock wurfl instance
        $service = $this->di->getModule();
        
        $capability = $service->search($ua);
       
        $this->assertInstanceOf('\WURFLExtension\Capability',$capability);
        
        $this->assertSame('safari_525_win',$capability->get('id'));
        
    }
    
    
    public function testBuild()
    {
        $resolver = $this->di->getModule()->build(array('\\WURFLExtension\\Decision\\Mobile' => function(WURFLExtension\Decision $decision){}));
        
        $this->assertInstanceOF('\WURFLExtension\Decision\Resolver',$resolver);
        
    }
    
    
    /**
      *  @expectedException \WURFLExtension\Exception
      *  @expectedExceptionMessage Decision Manager Class Does not exist 
      */
    public function testBuildBadDecisionsClassException()
    {
         $resolver = $this->di->getModule()->build(array('\\WURFLExtension\\Decision\\Empt' => function(WURFLExtension\Decision $decision){}));
        
    }
    
    
    public function testDecide()
    {
         $ua = "Mozilla/5.0 (Windows; U; Windows NT 6.1; zh-HK) AppleWebKit/533.18.1 (KHTML, like Gecko) Version/5.0.2 Safari/533.18.5";
         $resolver = $this->di->getModule()->build(array('\\WURFLExtension\\Decision\\Mobile' => function(WURFLExtension\Decision $decision){}));
         
         $this->assertFalse($this->di->getModule()->decide($resolver,$ua));
         
    }
   
}
/* End of File */