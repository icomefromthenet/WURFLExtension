<?php
namespace WURFLExtension\Decision;

/**
  *  Using the wurfl capabilties will run decisions 
  *  supplied in the constructor and the callback on the
  *  first manager to return true.
  */
class Resolver
{
    
    /**
      *  @var Decision[] 
      */
    protected $decisions;

    //  -------------------------------------------------------------------------
    
    /**
      *  Class Constructor
      *
      *  @param Decision[]
      */
    public function __construct(array $decisions)
    {
        $this->decisions = $decisions;
    }
    
    //  -------------------------------------------------------------------------
    
    /**
      *  Resolve a decision using the wurfl data
      *
      *  @param array $data wurfl data
      *
      *  If no voters return affirmative then ignore the return
      */
    public function resolve(array $data)
    {
        foreach($this->decisions as $decision) {
            
            if($decision->vote($data) === true) {
                
                # run the callback
                $decision->run();
                
                # don't test decision made
                break;    
            }
        }
        
        return true;
    } 

    //  -------------------------------------------------------------------------
}
/* End of File */