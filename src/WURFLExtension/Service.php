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
    
    
}
/* End of File */