<?php
include_once (realpath(__DIR__ .'/../../src/Vendor/TeraWurfl/TeraWurfl.php'));

class WurflInstanceTest extends PHPUnit_Framework_TestCase
{

    public function testNewInstance()
    {
        $wurfl = $this->getWurfl();
        $service = new Kernel_Extension_Wurfl_Instance($wurfl);
        
        $this->assertInstanceOf('Kernel_Extension_Wurfl_Instance',$service);
        
    }
    
    public function testDeviceParse()
    {
        $wurfl = $this->getWurfl();
        $service = new Kernel_Extension_Wurfl_Instance($wurfl);
        $ua = "Mozilla/5.0 (Windows; U; Windows NT 6.1; zh-HK) AppleWebKit/533.18.1 (KHTML, like Gecko) Version/5.0.2 Safari/533.18.5";
        $data = $service->parse($ua);
        $this->assertTrue(is_array($data));         
        
        return true;
        
    }
    
    public function test_lookup()
    {
        $wurfl = $this->getWurfl();
        $service = new Kernel_Extension_Wurfl_Instance($wurfl);
        $ua = "Mozilla/5.0 (Windows; U; Windows NT 6.1; zh-HK) AppleWebKit/533.18.1 (KHTML, like Gecko) Version/5.0.2 Safari/533.18.5";
        $data = $service->parse($ua);
        
        $value   = $data['ajax']['ajax_manipulate_css'];
        $product = $data['product_info']['brand_name'];       

        $this->assertEquals(true,$value);
        $this->assertEquals($product,'safari');
        
    }
    
    public function testCapability()
    {
        
        $wurfl = $this->getWurfl();
        $service = new Kernel_Extension_Wurfl_Instance($wurfl);
        $ua = "Mozilla/5.0 (Windows; U; Windows NT 6.1; zh-HK) AppleWebKit/533.18.1 (KHTML, like Gecko) Version/5.0.2 Safari/533.18.5";
        $data = $service->parse($ua);
       
       
        $capability = new Kernel_Extension_Wurfl_Capability($data);
        
        $value = $capability->get('ajax.ajax_manipulate_css');
        $product = $capability->get('product_info.brand_name');       

        $this->assertEquals(true,$value);
        $this->assertEquals($product,'safari');
        
        
        
    }
    
    //  -------------------------------------------------------------------------
    
    protected $wurfl;    
    
    protected function getWurfl()
    {
        if($this->wurfl === null) {
            $this->wurfl = new TeraWurfl();
        }
  
        return $this->wurfl;
    }
    
    //  -------------------------------------------------------------------------

}
/* End of File */