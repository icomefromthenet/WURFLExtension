<?php
namespace WURFLExtension\Command\Base;

use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use WURFLExtension\Module;

/*
 * class BaseApplication
 */

class Application extends BaseApplication
{

    protected $module;

    /**
      *  function setModule
      *
      *  @param \WURFLExtension\Module $module
      *  @access public
      */
    public function setModule(Module $module)
    {
        $this->module = $module;
    }

    /**
      *  function getModule
      *
      *  @access public
      *  @return WURFLExtension\Module
      */
    public function getModule()
    {
        return $this->module;
    }


    //  -------------------------------------------------------------------------

    /*
     * __construct()
     *
     * @param \WURFLExtension\Module $module
     *
     */
    public function __construct(Module $module)
    {   $name     = 'WURFLExtension';
        $version  = '1.0';

        parent::__construct($name,$version);
        
        #set the references
        $this->setModule($module);
    }

    //  --------------------------------------------------------------------------

     /**
     * Runs the current application.
     *
     * @param InputInterface  $input  An Input instance
     * @param OutputInterface $output An Output instance
     *
     * @return integer 0 if everything went fine, or an error code
     */
    public function doRun(InputInterface $input, OutputInterface $output)
    {

        return parent::doRun($input, $output);

    }
    
}
/* End of File */
