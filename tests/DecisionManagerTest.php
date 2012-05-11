<?php

class MockVoter1 implements Kernel_Extension_Wurfl_VoterInterface
{

    public function vote(array $data)
    {
        return true;
    }
    
}

class MockVoter2 implements Kernel_Extension_Wurfl_VoterInterface
{

    public function vote(array $data)
    {
        return true;
    }
    
}

class MockVoter3 implements Kernel_Extension_Wurfl_VoterInterface
{

    public function vote(array $data)
    {
        return false;
    }
    
}

class MockDecisionStrategy1 implements Kernel_Extension_Wurfl_StrategyInterface
{
    
    public function decide(array $data)
    {
        return true;    
    }
    
}


class MockDecisionStrategy2 implements Kernel_Extension_Wurfl_StrategyInterface
{
    
    public function decide(array $data)
    {
        return false;    
    }
    
}


class MockDecisionManager extends Kernel_Extension_Wurfl_DecisionManager
{
    
    
    public function run()
    {
        
    }
    
    public static function getCriteria()
    {
        
    }
    
   
    public static function getStrategy()
    {
        
    }

    
}


class DecisionManagerTest extends PHPUnit_Framework_TestCase
{
    public function testNewManager()
    {
        $decision = new MockDecisionStrategy1();
        $voters = array(new MockVoter1(), new MockVoter2());
        
        $manager = new MockDecisionManager($voters,$decision);
        
        $this->assertTrue(true);
        
    }
    
    
    public function testAffirmativeOperation()
    {
        $decision = new MockDecisionStrategy1();
        $voters = array(new MockVoter1(), new MockVoter2());
        
        $manager = new MockDecisionManager($voters,$decision);
        $data = array();
        
        $this->assertTrue($manager->vote($data));
    
    }
    
    public function testforNegative()
    {
        $decision = new MockDecisionStrategy2();
        $voters = array(new MockVoter1(), new MockVoter2());
        
        $manager = new MockDecisionManager($voters,$decision);
        $data = array();
        
        $this->assertFalse($manager->vote($data));
    
        $decision = new MockDecisionStrategy2();
        $voters = array(new MockVoter3(), new MockVoter3());
        
        $manager = new MockDecisionManager($voters,$decision);
        $data = array();
        
        $this->assertFalse($manager->vote($data));
     
        
    }
    
    /**
      *  @expectedException Kernel_Extension_Wurfl_Exception 
      */    
    public function testEmptyVoters()
    {
        $decision = new MockDecisionStrategy2();
        $voters = array();
        
        $manager = new MockDecisionManager($voters,$decision);
        $data = array();
        
        $manager->vote($data);
        
    }
    
    
    public function testResolverNoCallBackRun()
    {
       $manager =  $this->getMockBuilder('MockDecisionManager')
                        ->disableOriginalConstructor()
                        ->setMethods(array('vote','run'))
                        ->getMock();
        
        $manager->expects($this->once())
                ->method('vote');
        
        $manager->expects($this->never())
                ->method('run');
                
        $data = array();
        $resolver = new Kernel_Extension_Wurfl_Resolver(array($manager));
        
        $resolver->resolve($data);
        
    }

    
    public function testResolverCallBackRun()
    {
        
       $data = array();
       $referer = 'wurfl/web';
       $manager =  $this->getMockBuilder('MockDecisionManager')
                        ->disableOriginalConstructor()
                        ->setMethods(array('vote','run'))
                        ->getMock();
        
        # method vote called one with expected array() and return true
        
        $manager->expects($this->once())
                ->method('vote')
                ->with($this->equalTo($data))
                ->will($this->returnValue(true));
                
        # run should be called once because vote returned true
        
        $manager->expects($this->once())
                ->method('run')
                ->with($this->equalTo($referer));
                 
        $resolver = new Kernel_Extension_Wurfl_Resolver(array($manager));
        
        $resolver->resolve($data,$referer);
        
    }

    
}
/* End of File */