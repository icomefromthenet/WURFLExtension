<?php
namespace WURFLExtension;

use Symfony\Component\Pimple\Pimple;


class Container extends Pimple
{
    
    public function getTeraWurfl()
    {
        return $this['tera_wurfl'];
    }
    
    
    public function getConsole()
    {
        return $this['console'];
    }


    public function getModule()
    {
        return $this['module'];
    }
    
    
    public function getTeraWurflWrapper()
    {
        return $this['tera_wurfl_wrapper'];
    }
    
    
    /**
      *  Sets the decision factory
      *
      *  @access public
      *  @return Kernel_Extension_Wurfl_DecisionFactory
      */
    public function getDecisionFactory()
    {
        return $this->decision_factory;
    }
    
    
    //  ----------------------------------------------------------------------------
}
/* End of File */