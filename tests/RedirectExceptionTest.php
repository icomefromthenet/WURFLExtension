<?php

class RedirectExceptionTest extends PHPUnit_Framework_TestCase
{

    
    public function testExceptionProperties()
    {
        $request_url = '/web/ct';
        $referer_url = '/wurfl/web';
        
        $exc = new Kernel_Extension_Wurfl_RedirectException();
        
        $exc->setRedirectUrl($request_url);
        $exc->setRefererPath($referer_url);
        
        $this->assertSame($exc->getRedirectUrl(),$request_url);
        $this->assertSame($exc->getRefererPath(),$referer_url);
        
        # must be a 301 child so exceptions not recorded into error log
        $this->assertInstanceOf('Kernel_Http_Exception_301',$exc);
    }
    
    
    /**
      *  @expectedException Kernel_Extension_Wurfl_RedirectException 
      */
    public function testExceptionThrown()
    {
        $request_url = '/web/ct';
        $referer_url = '/wurfl/web';
        
        $exc = new Kernel_Extension_Wurfl_RedirectException();
        
        $exc->setRedirectUrl($request_url);
        $exc->setRefererPath($referer_url);
        
        throw $exc;
    }

}
/* End of File */

