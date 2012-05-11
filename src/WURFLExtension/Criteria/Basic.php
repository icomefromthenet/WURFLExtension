<?php
namespace WURFLExtension\Criteria;

use WURFLExtension\VoterInterface;

class Basic implements VoterInterface
{
    /**
      *  Test if the dive is marked as mobile
      *
      *  @return boolean if found
      */
    public function vote(array $data)
    {
        return (boolean) $data['product_info']['is_wireless_device'];
    }
    
}


/* End of File */