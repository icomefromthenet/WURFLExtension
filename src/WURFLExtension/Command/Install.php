<?php
namespace WURFLExtension\Command;

use WURFLExtension\Command\Base\Command,
    WURFLExtension\Exception as WURFLExtensionException,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Helper\DialogHelper,
    Symfony\Component\Console\Output\OutputInterface;

class Install extends Command
{

    protected function execute(InputInterface $input, OutputInterface $output)
    {

           $base = $this->getApplication()->getModule()->getContainer()->getTeraWurfl();
       
           # make data folder write and readable
           if(chmod($base->rootdir .'data', 0777)) {
               $output->writeln('<info>chmod<.info> '.$base->rootdir .'data');
           }else {
               throw new WURFLExtensionException('Can not make data directory writtable');
           }
              
           
           $output->writeln('<comment>Starting Installing TERAWurfl</comment>');
           
           if($base->db->connected !== true) {
             throw new WURFLExtensionException("Cannot connect to database: " . $base->db->errors[0]);
           }
           
           $loader = new TeraWurflLoader($base);
           
           # setup the database   
           if($base->db->initializeDB() === FALSE) {
               throw new WURFLExtensionException('unable tin initialize the database');
           }
           
           # apply the devices file 
           if ($loader->load() === TRUE) {
               $output->writeln("<comment>Database Update OK</comment>");
               $output->writeln("<info>Total Time:</info> " . $loader->totalLoadTime());
               $output->writeln("<info>Parse Time:</info> " . $loader->parseTime() . " (" . $loader->getParserName() . ")");
               $output->writeln("<info>Validate Time:</info> " . $loader->validateTime());
               $output->writeln("<info>Sort Time:</info> " . $loader->sortTime());
               $output->writeln("<info>Patch Time:</info> " . $loader->patchTime());
               $output->writeln("<info>Database Time:</info> " . $loader->databaseTime());
               $output->writeln("<info>Cache Rebuild Time:</info> " . $loader->cacheRebuildTime());
               $output->writeln("<info>Number of Queries:</info> " . $base->db->numQueries);
               $output->writeln("<info>PHP Memory Usage:</info> " . WurflSupport::formatBytes(memory_get_peak_usage()));
       
               $output->writeln("<comment>--------------------------------</comment>");
               $output->writeln("<info>WURFL Version:</info> " . $loader->version . " (" . $loader->last_updated . ")");
               $output->writeln("<info>WURFL Devices:</info> " . $loader->mainDevices);
               $output->writeln("<info>PATCH New Devices:</info> " . $loader->patchAddedDevices);
               $output->writeln("<info>PATCH Merged Devices:</info> " . $loader->patchMergedDevices);
           } else {
               throw new WURFLExtensionException(var_export($loader->errors, true));
           }
           
           $output->writeln('<comment>Finished Installing TERAWurfl</comment>');
           
           parent::execute($input,$output);
    }
    
    
    protected function configure() {

         $this->setName('wurfl:install')
              ->setDescription('Install TeraWurfl setup the database and apply the devies file')
              ->setHelp(<<<EOF
Will <info>setup database</info> and apply the <info>devices xml file</info>.

Example:

>> install.php wurfl:install 

EOF
                 );
        
        
        parent::configure();
    }

}
/* End of File */
