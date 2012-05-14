<?php
namespace WURFLExtension\Tests;

use WURFLExtension\Criteria\AndroidBrowser,
    WURFLExtension\Container,
    PHPUnit_Framework_TestCase;


class CriteriaAndroidBrowserTest extends PHPUnit_Framework_TestCase
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
    

    public function testLookup()
    {
        
        $service = $this->di->getTeraWurflWrapper();
        $criteria = new AndroidBrowser();
        
        # Apple Phone
        
        $ua = "Mozilla/5.0 (Windows; U; Windows NT 6.1; zh-HK) AppleWebKit/533.18.1 (KHTML, like Gecko) Version/5.0.2 Safari/533.18.5";
        $data = $service->parse($ua);
        
        $this->assertFalse($criteria->vote($data));
        
        # Andorid phone user agent
        
        $ua = 'Mozilla/5.0 (Linux; U; Android 1.0; xx-xx; dream) AppleWebKit/525.10  (KHTML, like Gecko) Version/3.0.4 Mobile Safari/523.12.2';
        $data = $service->parse($ua);
        
        
        $this->assertTrue($criteria->vote($data));
        
    }
    
}
/* End of File */