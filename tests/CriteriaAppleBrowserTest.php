<?php

include_once (realpath(__DIR__ .'/../../src/Vendor/TeraWurfl/TeraWurfl.php'));

class CriteriaAppleBrowserTest extends PHPUnit_Framework_TestCase
{

    public function testLookup()
    {
        $wurfl = $this->getWurfl();
        $service = new Kernel_Extension_Wurfl_Instance($wurfl);
        $criteria = new Kernel_Extension_Wurfl_Criteria_AppleBrowser();
        
        # Apple Phone
        $ua = "Mozilla/5.0 (iPhone; U; CPU like Mac OS X; en) AppleWebKit/420+ (KHTML, like Gecko) Version/3.0 Mobile/1A538a Safari/419.3";
        $data = $service->parse($ua);
        $this->assertTrue($criteria->vote($data));
        
        # Andorid phone user agent
        $ua = 'Mozilla/5.0 (Linux; U; Android 1.0; xx-xx; dream) AppleWebKit/525.10  (KHTML, like Gecko) Version/3.0.4 Mobile Safari/523.12.2';
        $data = $service->parse($ua);
        $this->assertFalse($criteria->vote($data));
        
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