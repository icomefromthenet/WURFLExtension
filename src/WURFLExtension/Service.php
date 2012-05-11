<?php

class Kernel_Extension_Wurfl_Service
{
    /**
      *  @var Zend_Session_Namespace 
      */
    protected $session;
    
    /**
      *  @var Kernel_Extension_Wurfl_Resolver 
      */
    protected $resolver;
    
    /**
      *  @var Kernel_Extension_Wurfl_Instance 
      */
    protected $instance;
    
    
    /**
      *  Class Constructor 
      */
    public function __construct(Kernel_Extension_Wurfl_Resolver $resolver, Zend_Session_Namespace $session, Kernel_Extension_Wurfl_Instance $instance)
    {
        $this->resolver = $resolver;
        $this->session  = $session;
        $this->instance = $instance;
    }
    
    
    //  -------------------------------------------------------------------------
    # Run
    
    /**
      *  Run a check if flag not set in session
      *
      *  @param string $referer_path used in the `return to link`
      *  @param string $user_agent the user agent to use in search
      *  @return true of check was run, false otherwise (lock was on)
      */
    public function run($referer_path,$user_agent)
    {
        # check session if we checked
        if($this->isLocked() === false) {
            $this->lock()->resolver->resolve($this->search($user_agent)->toArray(),$referer_path);  
            return true;
        }
        
        return false;
    }
    
    //  -------------------------------------------------------------------------
    # Lock Helpers
    

    public function lock()
    {
        $this->session->checked = true;
        
        return $this;
    }
    
    
    public function unlock()
    {
        $this->session->checked = false;
        
        return $this;
    }
    
    public function isLocked()
    {
        $is = false;
        
        if(isset($this->session->checked) === false) {
            return false;
        }
        
        if((boolean) $this->session->checked === false) {
            $is = false;
        } else {
            $is = true;
        }
        
        return $is;
        
    }
    
    //  -------------------------------------------------------------------------
    # Search will check the wurfl database for device

    /**
      *  Search the wurfl for database and dump into session
      *
      *  @var string $user_agent to use in the search
      *  @return Kernel_Extension_Wurfl_Capability
      */
    public function search($user_agent)
    {
        $data = $this->instance->parse($user_agent);
        
        # was data returned
        
        if(is_array($data) === false) {
            throw new Kernel_Extension_Wurfl_Exception('Returned data from Tera Wurfl must be and array');
        }
        
        # load search data into struct 
        
        $capability = new Kernel_Extension_Wurfl_Capability($data);
        
        # assign seach data into session
        $this->session->data = $capability;
         
        return $this->session->data;
    }

    //  -------------------------------------------------------------------------
    # Properties
    
    /**
      * Gets the loaded Capability Struct
      * 
      * @return Kernel_Extension_Wurfl_Capability 
      */
    public function getCapability()
    {
        if(isset($this->session->data)  === false) {
            return null;
        }
        
        return $this->session->data;
    }
    
    //  -------------------------------------------------------------------------
}
/* End of File */