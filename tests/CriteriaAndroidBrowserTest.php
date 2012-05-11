<?php
namespace WURFLExtension\Tests;

use WURFLExtension\Criteria\AndroidBrowser;

class CriteriaAndroidBrowserTest extends PHPUnit_Framework_TestCase
{

    public function testLookup()
    {
        $wurfl = $this->getWurfl();
        $service = new Kernel_Extension_Wurfl_Instance($wurfl);
        $criteria = new Kernel_Extension_Wurfl_Criteria_AndroidBrowser();
        
        # Apple Phone
        
        $ua = "Mozilla/5.0 (Windows; U; Windows NT 6.1; zh-HK) AppleWebKit/533.18.1 (KHTML, like Gecko) Version/5.0.2 Safari/533.18.5";
        $data = $service->parse($ua);
        
        $this->assertFalse($criteria->vote($data));
        
        # Andorid phone user agent
        
        $ua = 'Mozilla/5.0 (Linux; U; Android 1.0; xx-xx; dream) AppleWebKit/525.10  (KHTML, like Gecko) Version/3.0.4 Mobile Safari/523.12.2';
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