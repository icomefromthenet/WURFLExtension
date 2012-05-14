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
        return $this['decision_factory'];
    }
    
    
    //  ----------------------------------------------------------------------------
    
    public function __construct()
    {
        
        $this['tera_wurfl'] = $this->share(function($container){

            #Include Files need for Wurfl
       
           $TeraWurfl_PATH = WURFLEXTENSION_VENDOR_DIR .'/TeraWurfl/';
           
           # check if config has been set on the first time.
           if(is_file(WURFLEXTENSION_VENDOR_DIR .'/TeraWurfl/TeraWurflConfig.php') === false) {
               throw new Exception('TeraWurfl not found try running wurfl::merge');
           }
           
           
           require_once $TeraWurfl_PATH . 'TeraWurfl.php';
           require_once $TeraWurfl_PATH . 'TeraWurflLoader.php';
           require_once $TeraWurfl_PATH . 'TeraWurflXMLParsers/TeraWurflXMLParser.php';
           require_once $TeraWurfl_PATH . 'TeraWurflXMLParsers/TeraWurflXMLParser_XMLReader.php';
           require_once $TeraWurfl_PATH . 'TeraWurflXMLParsers/TeraWurflXMLParser_SimpleXML.php';
       
       
           # Change the memory limit
           ini_set("memory_limit", '768M');
       
           $base = new \TeraWurfl();
       
           //if ($base->db->connected !== true) {
             //  throw new Exception("Cannot connect to database: " . $base->db->errors[0]);
           //}
       
           return $base;
        });
      
        $this['console'] = $this->share(function($container){
           return new \WURFLExtension\Command\Base\Application($container['module']);
        });
      
        $this['module']  = $this->share(function($container){
           return new \WURFLExtension\Module($container);
        });
      
        $this['tera_wurfl_wrapper'] = $this->share(function($container){
           return new \WURFLExtension\TeraWurflWrapper($container['tera_wurfl']);
        });
            
        $this['decision_factory'] = $this->share(function($container){
           return new \WURFLExtension\Decision\Factory();
       }); 
        
        
    }
    
}
/* End of File */