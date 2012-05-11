<?php
namespace WURFLExtension\Decision;

use WURFLExtension\Strategy\Unanimous,
    WURFLExtension\Criteria\Screen,
    WURFLExtension\Criteria\Basic;

class Mobile extends Decision
{
    
    public static function getCriteria()
    {
        return array(
                new Screen(480,320),
                new Basic()
            );
    }
    
    public static function getStrategy()
    {
        return new Unanimous();
    }

}
/* End of File */