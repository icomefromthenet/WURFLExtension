<?php
namespace WURFLExtension\Criteria;

use WURFLExtension\VoterInterface,
    WURFLExtension\Exception as WURFLExtensionException;

/**
  *  Run a test on the device screen height
  *
  *  Accepts to params:
  *  1. Max screen height
  *  2. Max screen width
  *
  *  Only returns true when both exceed the max or when device heights = 0 (deskops)
  *
  *  @link http://wurfl.sourceforge.net/help_doc.php#display (as terra-wurfl project does not provide information, close but no always the same)
  */
class Screen implements VoterInterface
{
    
    /**
      *  @var integer assumes the dimensions provided are maxiums
      */
    const MAX = 0;
    
    /**
      *  @var integer assumes the dimensions provided are minimums 
      */
    CONST MIN = 1;
    
    
    /**
      *  @var integer the maxium screen height 
      */
    protected $height;
    
    
    /**
      *  @var integer the maxium screen width 
      */
    protected $width;
    
    /**
      *  @var integer the type of test to use 
      */
    protected $type;
    
    
    public function __construct($height,$width,$type = self::MAX)
    {
        $this->height = (integer) $height;
        $this->width  = (integer) $width;
        $this->type   = (integer) $type; 
    }
    
    
    /**
      *  Test if the device has the android webkit browser
      *
      *  @return true if matched
      *  @param array device capability array produced by tera-wurfl
      */
    public function vote(array $data)
    {
        # Check if the high within range
        $height = (integer) $data['display']['resolution_height'];
                
        # Check if the width is in range
        $width = (integer) $data['display']['resolution_width']; 
        
        $height_test = false;
        $width_test  = false;
        
        if($this->type === self::MAX) {
        
            if($height <=  $this->height && $height > 0) {
                $height_test = true;
            }
            
            if($width <= $this->width && $width > 0) {
                $width_test = true;
            }
        
        } elseif($this->type === self::MIN) {
            
            if($height >=  $this->height && $height > 0) {
                $height_test = true;
            }
            
            if($width >= $this->width && $width > 0) {
                $width_test = true;
            }
            
        } else {
            throw new WURFLExtensionException('No Test has been specified');
        }
        
        return ($height_test === true && $width_test === true) ? true : false;
        
    }
    
}
/* End of File */