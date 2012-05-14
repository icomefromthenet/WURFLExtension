<?php
namespace WURFLExtension\Tests;

use WURFLExtension\Criteria\Basic,
    WURFLExtension\Container,
    PHPUnit_Framework_TestCase;

class CriteriaBasicTest extends PHPUnit_Framework_TestCase
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
        $criteria = new Basic();
        
        # Value is false or empty string
        
        $ua = "Mozilla/5.0 (Windows; U; Windows NT 6.1; zh-HK) AppleWebKit/533.18.1 (KHTML, like Gecko) Version/5.0.2 Safari/533.18.5";
        $data = $service->parse($ua);
        
        
        $this->assertFalse($criteria->vote($data));
        
        # Value is true
        
        $ua = 'Mozilla/5.0 (iPhone; U; CPU like Mac OS X; en) AppleWebKit/420.1 (KHTML, like Gecko) Version/3.0 Mobile/3B48a Safari/419.3';
        $data = $service->parse($ua);
        
        
        $this->assertTrue($criteria->vote($data));
        
    }
    
    
    
  

}
/* End of File */