<?php
namespace WURFLExtension\Tests;

use WURFLExtension\Criteria\AppleBrowser,
    WURFLExtension\Container,
    PHPUnit_Framework_TestCase;

class CriteriaAppleBrowserTest extends PHPUnit_Framework_TestCase
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
        $criteria = new AppleBrowser();
        
        # Apple Phone
        $ua = "Mozilla/5.0 (iPhone; U; CPU like Mac OS X; en) AppleWebKit/420+ (KHTML, like Gecko) Version/3.0 Mobile/1A538a Safari/419.3";
        $data = $service->parse($ua);
        $this->assertTrue($criteria->vote($data));
        
        # Andorid phone user agent
        $ua = 'Mozilla/5.0 (Linux; U; Android 1.0; xx-xx; dream) AppleWebKit/525.10  (KHTML, like Gecko) Version/3.0.4 Mobile Safari/523.12.2';
        $data = $service->parse($ua);
        $this->assertFalse($criteria->vote($data));
        
    }
    
    

}
/* End of File */