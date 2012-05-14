<?php
namespace WURFLExtension\Criteria;

use WURFLExtension\VoterInterface;

class AndroidBrowser implements VoterInterface
{
    
    /**
      *  Test if the device has the android webkit browser
      *
      *  @return true if matched
      *  @param array device capability array produced by tera-wurfl
      */
    public function vote(array $data)
    {
        # check if the product info has android webkeit set as browser
        
        $test = 'androidwebkit';
        $result = false;
        
        # prep test value for comparison by removing spaces and converting to lowercase
        $comparison = str_ireplace(' ','',strtolower((string) $data['product_info']['mobile_browser']));
        
        return ($comparison === $test) ? true : $result;
    }
    
}
/* End of File */