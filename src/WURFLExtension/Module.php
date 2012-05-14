<?php
namespace WURFLExtension;

use WURFLExtension\Exception as WURFLExtensionException,
    WURFLExtension\Container,
    WURFLExtension\Capability,
    WURFLExtension\Decision\Resolver;

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
        $data = $this->container->getTeraWurflWrapper()->parse($user_agent);
        
        # was data returned
        
        if(is_array($data) === false) {
            throw new WURFLExtensionException('Returned data from Tera Wurfl must be and array');
        }
        
        # load search data into struct 
        
        return new Capability($data);
        
    }

    //  -------------------------------------------------------------------------
    
    /**
      *  Will make a decision using a decision resolver.
      *
      *  @param Resolver $decision
      *  @param String $user_agent
      */
    public function decide(Resolver $decision,$user_agent)
    {
        return $decision->resolve($this->search($user_agent)->toArray());
    }
    
    //  -------------------------------------------------------------------------
    
    
    /**
      *   Turn array of decisions/callbacks into a resolver
      *
      *   @param mixed[] array of 'decision_class_name' => Closure
      *   @return Resolver
      */
    public function build(array $decisions)
    {
        $decide = array();
        
        foreach($decisions as $name => $closure) {
            $decide[] = $this->container->getDecisionFactory()->create($name,$closure);
        }
        
        return new Resolver($decide);
    }
    
    //  -------------------------------------------------------------------------
    
}
/* End of File */