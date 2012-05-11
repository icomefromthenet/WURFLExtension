<?php
namespace WURFLExtension;


class Module
{
    /**
      * @var Container the dependency Container
      */
    protected $container;
    
    /**
      *  Fetcht the Dependency Container
      *
      *  @return Container
      *  @access public
      */
    public function getContainer()
    {
        return $this->container;
    }
    
    
    
    public function __construct(Container $container)
    {
        $this->container = $container;
        
    }
    
    
    public function __destruct()
    {
        unset($this->container);
        
    }
    
    
    
    
    
    
    
    
    # Build Resolver

    public function createResolver()
    {
        $instanced_managers = array();
        
        # check for decision classes from the config folder
        $managers = $this->getConfig()->get('theme.wurfl_decision_managers',null);
        
        
        # make sure been set as an array or loop below will fail
        
        if($managers !== null) {
            # instance the managers using the factory
            
            foreach($managers as $manager) {
                $instanced_managers[] = $this->getDecisionFactory()->create($manager);
            }
        }

        # return the new resolver
        return new Kernel_Extension_Wurfl_Resolver($instanced_managers);
    }
    
    
}
/* End of File */