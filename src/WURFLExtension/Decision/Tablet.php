<?php
namespace WURFLExtension\Decision;

use WURFLExtension\Criteria\Screen,
    WURFLExtension\Criteria\Basic,
    WURFLExtension\Strategy\Unanimous,
   
class Tablet extends Decision
{
    
    public static function getCriteria()
    {
        # test if we have a wireless device and screen resolution of 10 inch tabet 1024*600
        
        return array(
                new Screen(1024,600, Screen::MIN),
                new Basic()
            );
    }
    
    public static function getStrategy()
    {
        return new Unanimous();
    }

}
/* End of File */