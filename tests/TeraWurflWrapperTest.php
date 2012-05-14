<?php
namespace WURFLExtension\Tests;

use TeraWurfl,
    WURFLExtension\TeraWurflWrapper,
    WURFLExtension\Capability,
    WURFLExtension\Container,
    PHPUnit_Framework_TestCase;

class TeraWurflWrapperTest extends PHPUnit_Framework_TestCase
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

    public function testNewInstance()
    {
        $wurfl = $this->di->getTeraWurfl();
        $service = new TeraWurflWrapper($wurfl);
        
        $this->assertInstanceOf('WURFLExtension\TeraWurflWrapper',$service);
        
    }

    
    public function testDeviceParse()
    {
        $wurfl = $this->di->getTeraWurfl();
        $service = new TeraWurflWrapper($wurfl);
        $ua = "Mozilla/5.0 (Windows; U; Windows NT 6.1; zh-HK) AppleWebKit/533.18.1 (KHTML, like Gecko) Version/5.0.2 Safari/533.18.5";
        $data = $service->parse($ua);
        $this->assertTrue(is_array($data));         
        
        return true;
        
    }
    
    public function test_lookup()
    {
        $wurfl = $this->di->getTeraWurfl();
        $service = new TeraWurflWrapper($wurfl);
        $ua = "Mozilla/5.0 (Windows; U; Windows NT 6.1; zh-HK) AppleWebKit/533.18.1 (KHTML, like Gecko) Version/5.0.2 Safari/533.18.5";
        $data = $service->parse($ua);
        
        $value   = $data['ajax']['ajax_manipulate_css'];
        $product = $data['product_info']['brand_name'];       

        $this->assertEquals(true,$value);
        $this->assertEquals($product,'safari');
        
    }
    
    public function testCapability()
    {
        
        $wurfl = $this->di->getTeraWurfl();
        $service = new TeraWurflWrapper($wurfl);
        
        $ua = "Mozilla/5.0 (Windows; U; Windows NT 6.1; zh-HK) AppleWebKit/533.18.1 (KHTML, like Gecko) Version/5.0.2 Safari/533.18.5";
        $data = $service->parse($ua);
       
       
        $capability = new Capability($data);
        
        $value = $capability->get('ajax.ajax_manipulate_css');
        $product = $capability->get('product_info.brand_name');       

        $this->assertEquals(true,$value);
        $this->assertEquals($product,'safari');
        
        
        
    }

}
/* End of File */