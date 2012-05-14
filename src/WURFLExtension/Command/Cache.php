<?php
namespace WURFLExtension\Command;

use WURFLExtension\Command\Base\Command,
    WURFLExtension\Exception as WURFLExtensionException,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Helper\DialogHelper,
    Symfony\Component\Console\Output\OutputInterface,
    \TeraWurflLoader,
    \TeraWurfl,
    \WurflSupport,
    \TeraWurflConfig;

class Cache extends Command
{
    
    const CLEAR_ARGUMENT = 'clear';
    
    
    const UPDATE_ARGUMENT = 'update';
    

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $command = $input->getArgument('action');
        $base = $this->getApplication()->getModule()->getContainer()->getTeraWurfl();
      
        if (strtolower($command) === self::CLEAR_ARGUMENT) {
            $base->db->createCacheTable();
            $output->writeln('Device cache has been cleared');
        }else if (strtolower($command) === self::UPDATE_ARGUMENT) {
            $base->db->createCacheTable();
            $output->writeln('Device cache has been rebuilt');
        } else {
            throw new WURFLExtensionException('Action argument is invalid at '.$command);
        }
        
        parent::execute($input,$output);
    
    }
    
    
     protected function configure() {

         $this->setName('wurfl:cache')
              ->setDescription('Clear or Update the Wurfl cache tables')
              ->setHelp(<<<EOF
Will <info>clear</info> cache tables or <info>update</info> the cache table

Example:

<comment>Will update cache table</comment>
>> install.php wurfl:cache update

<comment>Will clear the cache table</comment>
>> install.php wurfl:cache clear


EOF
                 )->addArgument('action',
                    InputArgument::REQUIRED,
                    'action to use clear|update');
        
        
        parent::configure();
    }


}
/* End of File */