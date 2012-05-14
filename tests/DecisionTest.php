<?php
namespace WURFLExtension\Tests;

use PHPUnit_Framework_TestCase,
    WURFLExtension\Container,
    WURFLExtension\VoterInterface,
    WURFLExtension\StrategyInterface,
    WURFLExtension\Decision\Resolver,
    WURFLExtension\Decision\Decision;
    
class DecisionTest extends PHPUnit_Framework_TestCase
{
    
    protected $backupGlobalsBlacklist = array('di_container');
    
    
    public function testNewManager()
    {
        $decision_strategy = $this->getMockBuilder('\WURFLExtension\StrategyInterface')->getMock();
        
        $mock_criteria1 = $this->getMockBuilder('\WURFLExtension\VoterInterface')->getMock();
        
        $mock_criteria2 = $this->getMockBuilder('\WURFLExtension\VoterInterface')->getMock();
        
        $manager = new Decision(array($mock_criteria1, $mock_criteria2),$decision_strategy,function(){});
        
        $this->assertTrue(true);
        
    }
    
    
    public function testAffirmativeOperation()
    {
        $decision_strategy = $this->getMockBuilder('\WURFLExtension\StrategyInterface')->getMock();
        $decision_strategy->expects($this->once())
                 ->method('decide')
                 ->will($this->returnValue(true));
       
        $mock_criteria1 = $this->getMockBuilder('\WURFLExtension\VoterInterface')->getMock();
        $mock_criteria1->expects($this->once())
                    ->method('vote')
                    ->will($this->returnValue(true));
        
        $mock_criteria2 = $this->getMockBuilder('\WURFLExtension\VoterInterface')->getMock();
        $mock_criteria2->expects($this->once())
                    ->method('vote')
                    ->will($this->returnValue(true));
       
        $decision = new Decision(array($mock_criteria1, $mock_criteria2),$decision_strategy,function(){});
        $data = array();
        
        $this->assertTrue($decision->tally($data));
    
    }
    
    public function testforNegative()
    {
        $decision_strategy = $this->getMockBuilder('\WURFLExtension\StrategyInterface')->getMock();
        $decision_strategy->expects($this->exactly(2))
                 ->method('decide')
                 ->will($this->returnValue(false));
        
        $mock_criteria1 = $this->getMockBuilder('\WURFLExtension\VoterInterface')->getMock();
        $mock_criteria1->expects($this->once())
                    ->method('vote')
                    ->will($this->returnValue(true));
        
        $mock_criteria2 = $this->getMockBuilder('\WURFLExtension\VoterInterface')->getMock();
        $mock_criteria2->expects($this->once())
                    ->method('vote')
                    ->will($this->returnValue(true));
        
        $decision = new Decision(array($mock_criteria1, $mock_criteria2),$decision_strategy,function(){});
        $data = array();

        $this->assertFalse($decision->tally($data));
    
    
        $mock_criteria3 = $this->getMockBuilder('\WURFLExtension\VoterInterface')->getMock();
        $mock_criteria3->expects($this->exactly(2))
                    ->method('vote')
                    ->will($this->returnValue(false));
    

        $decision = new Decision(array($mock_criteria3, $mock_criteria3),$decision_strategy,function(){});
        $data = array();
        
        $this->assertFalse($decision->tally($data));
     
        
    }
    
   
   
    /**
      *  @expectedException WURFLExtension\Exception 
      */ 
    public function testEmptyVoters()
    {
        $decision_strategy = $this->getMockBuilder('\WURFLExtension\StrategyInterface')->getMock();
        
        $decision = new Decision(array(),$decision_strategy,function(){});
        $data = array();
        $decision->tally($data);
        
    }
    
    
  
    public function testResolverNoCallToRun()
    {
        $decision =  $this->getMockBuilder('\WURFLExtension\Decision\Decision')
                        ->disableOriginalConstructor()
                        ->setMethods(array('tally','run'))
                        ->getMock();
        
        $decision->expects($this->once())
                ->method('tally');
        
        $decision->expects($this->never())
                ->method('run');
                
        $data = array();
        $resolver = new Resolver(array($decision));
        $resolver->resolve($data);
        
    }

    
 
    public function testResolverCallToRunMade()
    {
        
       $data = array();
       $decision =  $this->getMockBuilder('\WURFLExtension\Decision\Decision')
                        ->disableOriginalConstructor()
                        ->setMethods(array('tally','run'))
                        ->getMock();
        
        # method vote called one with expected array() and return true
        
        $decision->expects($this->once())
                ->method('tally')
                ->with($this->equalTo($data))
                ->will($this->returnValue(true));
                
        # run should be called once because vote returned true
        
        $decision->expects($this->once())
                ->method('run');
                 
        $resolver = new Resolver(array($decision));
        $resolver->resolve($data);
    }

    
}
/* End of File */