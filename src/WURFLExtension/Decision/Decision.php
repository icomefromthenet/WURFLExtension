<?php
namespace WURFLExtension\Decision;

use Closure,
    WURFLExtension\Exception as WURFLExtensionException,
    WURFLExtension\StrategyInterface,
    WURFLExtension\VoterInterface,

class Decision
{
    
    /**
      *  @var StrategyInterface 
      */
    protected $strategy;
    
    /**
      * @var array VoterInterface, the voters to use 
      */
    protected $voters = array();
    
    /**
      *  @var Closure 
      */
    protected $action = null;
    
    /**
      *  Class Constrcutor
      *
      *  @param array $voters VoterInterface, the voters to use
      *  @param StrategyInterface  a strategy to use
      *  @param Closure $action
      */
    public function __construct(array $voters, StrategyInterface $strategy, Closure $action)
    {
        $this->strategy = $strategy;
        $this->voters = $voters;
        $this->action = $action;
    }
    
    
    /**
      *  Run the voters again a decision strategy
      *
      *  @param array the wurfl device capabilities array
      *  @return boolean true if decision was in the affirmative
      */
    public function vote(array $data)
    {
        
        $results = array();
        
        # verify that voters have been set
        
        if(count($this->voters) <= 0 ) {
            throw new WURFLExtensionException('No Voters to use can not make a decision');
        }
        
        # verify a decision strategy has been set
        
        if(($this->strategy instanceof StrategyInterface) === false) {
            throw new WURFLExtensionException('No Decision Strategy has been set');
        }
        
        # run through an collect vote results
        
        foreach($this->voters as $voter) {
            $results[] = $voter->vote($data);
        }
        
        # pass results to strategy for resolution
        
        return $this->strategy->decide($results);
        
    }
    
    //  ----------------------------------------------------------------------------
    # Callback Abstract
    
    /**
      *  Override in concrete classes if want to do any post or pre action stuff
      *
      *  @access public
      */
    public function run()
    {
        return $this->action($this);    
    }
    
    
    //  -------------------------------------------------------------------------
    # Abstract Factory for criteria
    
    /**
      *  Overriden in concrent classes
      *
      *  @access public
      *  @return VoterInterface[]
      */
    public static function getCriteria(){}
    
    
    /**
      *  Overriden in concrent class
      *
      *  @access public
      *  @return StrategyInterface
      */
    public static function getStrategy(){}
    
    
    
}
/* End of File */