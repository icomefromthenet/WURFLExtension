<?php

include_once (realpath(__DIR__ .'/../../src/Vendor/TeraWurfl/TeraWurfl.php'));

class CriteriaBasicTest extends PHPUnit_Framework_TestCase
{

    public function testLookup()
    {
        $wurfl = $this->getWurfl();
        $service = new Kernel_Extension_Wurfl_Instance($wurfl);
        $criteria = new Kernel_Extension_Wurfl_Criteria_Basic();
        
        # Value is false or empty string
        
        $ua = "Mozilla/5.0 (Windows; U; Windows NT 6.1; zh-HK) AppleWebKit/533.18.1 (KHTML, like Gecko) Version/5.0.2 Safari/533.18.5";
        $data = $service->parse($ua);
        
        
        $this->assertFalse($criteria->vote($data));
        
        # Value is true
        
        $ua = 'Mozilla/5.0 (iPhone; U; CPU like Mac OS X; en) AppleWebKit/420.1 (KHTML, like Gecko) Version/3.0 Mobile/3B48a Safari/419.3';
        $data = $service->parse($ua);
        
        
        $this->assertTrue($criteria->vote($data));
        
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


/* End of File */