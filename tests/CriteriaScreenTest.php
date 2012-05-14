<?php
namespace WURFLExtension\Tests;

use WURFLExtension\Criteria\Screen,
    WURFLExtension\Container,
    PHPUnit_Framework_TestCase;

class CriteriaScreenTest extends PHPUnit_Framework_TestCase
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
        
        # Apple Phone (600*800) 
        $criteria = new Screen(1024,768);
        $ua = "Mozilla/5.0 (Windows; U; Windows NT 6.1; zh-HK) AppleWebKit/533.18.1 (KHTML, like Gecko) Version/5.0.2 Safari/533.18.5";
        $data = $service->parse($ua);
        $vote = $criteria->vote($data);
        $this->assertFalse($vote);
        
        # Apple Phone (600*800) 
        $criteria = new Screen(1024,768,Screen::MIN);
        $ua = "Mozilla/5.0 (Windows; U; Windows NT 6.1; zh-HK) AppleWebKit/533.18.1 (KHTML, like Gecko) Version/5.0.2 Safari/533.18.5";
        $data = $service->parse($ua);
        $vote = $criteria->vote($data);
        $this->assertFalse($vote);
        
        $criteria = new Screen(600,800);
        $data = $service->parse($ua);
        $vote = $criteria->vote($data);
        $this->assertTrue($vote);
                
        $criteria = new Screen(600,900,Screen::MIN);
        $data = $service->parse($ua);
        $vote = $criteria->vote($data);
        $this->assertFalse($vote);
        
        # Andorid phone user agent (480 *320)
        $criteria = new Screen(480,320);
        $ua = 'Mozilla/5.0 (Linux; U; Android 1.0; xx-xx; dream) AppleWebKit/525.10  (KHTML, like Gecko) Version/3.0.4 Mobile Safari/523.12.2';
        $data = $service->parse($ua);
        $this->assertTrue($criteria->vote($data));
        
        # Test on a desktop
        $criteria = new Screen(480,320);
        $ua = 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:11.0) Gecko/20100101 Firefox/11.0';
        $data = $service->parse($ua);
        $this->assertFalse($criteria->vote($data));
        
        
        # test Emulator UserAgent
        $ua = 'Mozilla/5.0 (Linux; U; Android 2.3.3; en-us; sdk Build/GRI34) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1';
        $data = $service->parse($ua);
        
        
    }
    
    
}
/* End of File */