<?php
namespace WURFLExtension\Strategy;

use WURFLExtension\StrategyInterface;

/**
  *  Will return a negative decision if one of the voters returns negative result.
  *  All votes will need to return positive if an affirmative decision to be
  *  reached.
  */
class Unanimous implements StrategyInterface
{
    
    public function decide(array $data)
    {
        $grant = 0;
        foreach ($data as $vote) {

                switch ($vote) {
                    case true:
                        ++$grant;

                        break;

                    case false:
                        return false;

                    default:
                        break;
                }
        }
        
        // no deny votes
        if ($grant > 0) {
            return true;
        }

        return false;
    }
    
    
}
/* End of File */