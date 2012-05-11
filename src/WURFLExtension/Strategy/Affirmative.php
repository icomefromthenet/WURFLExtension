<?php
namespace WURFLExtension\Strategy;

use WURFLExtension\StrategyInterface;

/**
  *  Will return a affirmative decision on the first voter that reports true
  *
  *  
  */
class Affirmative implements StrategyInterface
{
    
    public function decide(array $data)
    {
        $deny = 0;
        foreach ($data as $vote) {
            switch ($vote) {
                case true:
                    return true;

                case false:
                    ++$deny;

                    break;

                default:
                    break;
            }
        }

        if ($deny > 0) {
            return false;
        }    
    }
    
    
}
/* End of File */