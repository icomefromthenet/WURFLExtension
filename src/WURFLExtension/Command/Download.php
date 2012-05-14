<?php
namespace WURFLExtension\Command;

use WURFLExtension\Command\Base\Command,
    WURFLExtension\Exception as WURFLExtensionException,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Helper\DialogHelper,
    Symfony\Component\Console\Output\OutputInterface,
    Symfony\Component\Finder\Finder,
    \TeraWurfl,
    \TeraWurflConfig,
    \WurflSupport;

class Download extends Command
{
   
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $base = $this->getApplication()->getModule()->getContainer()->getTeraWurfl();
        $newfile   = TeraWurfl::absoluteDataDir(). TeraWurflConfig::$WURFL_FILE .'.gz';
        $dl_url    = TeraWurflConfig::$WURFL_CVS_URL;
     
        $output->writeln("Downloading WURFL from $dl_url ...");
     
        # make data folder write and readable
        if(chmod(TeraWurfl::absoluteDataDir(), 0777)) {
             $output->writeln('<info>chmod</info> '.$base->rootdir .'data');
        } else {
             throw new WURFLExtensionException('Can not make data directory writtable');
        }
            
        
        # check if datadir exists and is writeble
        if (!file_exists($newfile) && !is_writable(TeraWurfl::absoluteDataDir())) {
             $base->toLog("Cannot write to data directory (permission denied)", LOG_ERR);
             throw new WURFLExtensionException("Fatal Error: Cannot write to data directory (permission denied). (" . TeraWurfl::absoluteDataDir() . ") Please make the data directory writable by the user or group that runs the webserver process, in Linux this command would do the trick if you're not too concerned about security: chmod -R 777 " . $base->rootdir . TeraWurflConfig::$DATADIR);
        }
       
        # check if file exist , should not be override a file by default
        if (file_exists($newfile) && !is_writable($newfile)) {
             $base->toLog("Cannot overwrite WURFL file (permission denied)", LOG_ERR);
             throw new WURFLExtensionException("Fatal Error: Cannot overwrite WURFL file (permission denied). (" . TeraWurfl::absoluteDataDir() . ") Please make the data directory writable by the user or group that runs the webserver process, in Linux this command would do the trick if you're not too concerned about security: chmod -R 777 " . $base->rootdir . TeraWurflConfig::$DATADIR);
             
        } else {
             
             $files = new Finder();
             $files->files()
                  ->name(TeraWurflConfig::$WURFL_FILE)
                  ->depth('== 0')
                  ->in(TeraWurfl::absoluteDataDir());
             
             foreach($files as $file) {
                unlink($file->getRealpath());
                break; //only be one file match
             }
        }
         
         # download the new WURFL file into the DATADIR
        $download_start = microtime(true);
        system(sprintf("wget -O %s %s",$newfile,$dl_url));
        
        if(is_file($newfile) === FALSE) {
             throw new WURFLExtensionException('unable to download the compressed update file');
        }
         
        # report the download
        $download_time = microtime(true) - $download_start;
        $size = WurflSupport::formatBytes(filesize($newfile));
        $download_rate = WurflSupport::formatBitrate(filesize($newfile), $download_time);
         
        $output->writeln("<info>done</info> (".$newfile.": $size) Downloaded in $download_time sec @ $download_rate");
         
        # check if we need to uncompress the file.
        if(is_file($newfile) === true) {
            $output->writeln('<info>un-compressing_file</info> :: '.$newfile);
            system(sprintf('gzip -d %s',$newfile));
            
        }
        
        parent::execute($input,$output);
         
    }
    
    
    
         protected function configure() {

         $this->setName('wurfl:download')
              ->setDescription('Download an update device definition xml file')
              ->setHelp(<<<EOF
Will <info>download</info> not apply an the device defintion file from the web
uses gzip to uncompress the file and wget to download.

Example:

<comment>Will download the file</comment>
>> install.php wurfl:download

EOF
                 );
        
        
        parent::configure();
    }

}
/* End of File */ 