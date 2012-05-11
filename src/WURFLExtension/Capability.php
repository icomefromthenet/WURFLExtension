<?php
namespace WURFLExtension;

use \Serializable;

class Capability  implements Serializable
{
    
    /**
      *  @var array 
      */
    protected $capability;
    
    
    public function __construct(array $capability = array())
    {
        $this->capability = $capability;
    }
    
    /**
      *  Gets a device Compability
      *
      *  @param capability name
      *  @param default value
      *  @return array or null if no capability exists
      */
    public function get($param,$default = null)
    {
        
        if(isset($this->capability[$param])){
            return $this->capability[$param];        
        }
        
        if (strpos($param, '.') !== false) {
            $parts = explode('.', $param);

            switch (count($parts)) {
                case 2:
                    if (isset($this->capability[$parts[0]][$parts[1]])) {
                        return $this->capability[$parts[0]][$parts[1]];
                    }
                    break;

                case 3:
                    if (isset($this->capability[$parts[0]][$parts[1]][$parts[2]])) {
                        return $this->capability[$parts[0]][$parts[1]][$parts[2]];
                    }
                    break;

                case 4:
                    if (isset($this->capability[$parts[0]][$parts[1]][$parts[2]][$parts[3]])) {
                        return $this->capability[$parts[0]][$parts[1]][$parts[2]][$parts[3]];
                    }
                    break;

                default:
                    $return = false;
                    foreach ($parts as $part) {
                        if ($return === false and isset($this->capability[$part])) {
                            $return = $this->capability[$part];
                        } elseif (isset($return[$part])) {
                            $return = $return[$part];
                        } else {
                            return $default;
                        }
                    }
                    return $return;
                    break;
            }
        }

        return $default;
    
    }
    
    
    //  -------------------------------------------------------------------------
    # Serializable
    
    public function serialize()
    {
        return serialize($this->capability);
    }
    
    
    public function unserialize($data)
    {
        $this->capability = unserialize($data);
    }    
    
    
    //  -------------------------------------------------------------------------
    # To Array
    
    public function toArray()
    {
        return $this->capability;
    }
    
    //  -------------------------------------------------------------------------
}


/* End of File */