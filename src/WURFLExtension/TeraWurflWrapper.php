<?php
namespace WURFLExtension;

use TeraWurfl,
    WURFLExtension\Exception as WURFLExtensionException;


class TeraWurflWrapper
{
    
    /**
      *  TeraWurfl 
      */
    protected $manager;
    
    
    public function __construct(TeraWurfl $wurfl)
    {
        $this->manager = $wurfl;
    }
    
    
    /**
      *  Parse the user agent string
      *
      *  @param string $user_agent
      *  @return array of device data
      */
    public function parse($user_agent)
    {
        try {
        
            $result = $this->manager->getDeviceCapabilitiesFromAgent($user_agent);
            
        } catch(Exception $e) {

            throw new WURFLExtensionException('Unable to parse useragent string::'.$user_agent);
        }
        
        return $this->manager->capabilities;
    }
    
    
}
/* End of File */