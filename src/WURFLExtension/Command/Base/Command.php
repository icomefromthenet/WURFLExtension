<?php
namespace WURFLExtension\Command\Base;

use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use WURFLExtension\Module;
use WURFLExtension\Exception as WURFLExtensionException;

class Command extends BaseCommand
{

    /**
     * Returns the Basic header.
     *
     * @return string the header string
     */
    public function getHeader()
    {
        return <<<EOF
<info>
WW      WW UU   UU RRRRRR  FFFFFFF LL      
WW      WW UU   UU RR   RR FF      LL      
WW   W  WW UU   UU RRRRRR  FFFF    LL      
 WW WWW WW UU   UU RR  RR  FF      LL      
 WW   WW   UUUUU  RR   RR FF      LLLLLLL 
   
</info>

EOF;

}

     //  -------------------------------------------------------------------------

  /**
     * Returns the Basic footer.
     *
     * @return string the footer string
     */
      
  public function getFooter()
    {
        return <<<EOF

<info>
Finished.  
</info>


EOF;

}
    
     //  -------------------------------------------------------------------------

    /**
     * Configures the current command.
     */
    protected function configure()
    {

       
    }

     //  -------------------------------------------------------------------------
    
    /**
     * Initializes the command just after the input has been validated.
     *
     * This is mainly useful when a lot of commands extends one main command
     * where some things need to be initialized based on the input arguments and options.
     *
     * @param InputInterface  $input  An InputInterface instance
     * @param OutputInterface $output An OutputInterface instance
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $output->writeLn($this->getHeader());
    }

    //  -------------------------------------------------------------------------
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeLn($this->getFooter());
    }
    
     //  -------------------------------------------------------------------------
    
}
/* End of File */
