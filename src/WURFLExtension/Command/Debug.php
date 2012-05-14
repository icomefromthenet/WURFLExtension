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
    \TeraWurflConfig,
    \UserAgentFactory;

class Debug extends Command
{
    
    /**
     * Interacts with the user.
     *
     * @param InputInterface  $input  An InputInterface instance
     * @param OutputInterface $output An OutputInterface instance
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $base = $this->getApplication()->getModule()->getContainer()->getTeraWurfl();
        $command = $input->getArgument('action');
        $file_argument = $input->getArgument('file');
        $quiet = $input->getOption('verbose');
        
        $output->writeLn('Running Debug');
            
        switch ($command) {
                case "constIDgrouped":
                    $matcherList = UserAgentFactory::$matchers;
                    
                    foreach ($matcherList as $matcher) {
                        $matcherClass = $matcher . "UserAgentMatcher";
                        
                        $file = $base->rootdir . "UserAgentMatchers/{$matcherClass}.php";
                        
                        require_once($file);

                        $matcherClass = '\\'.$matcherClass;
                        $ids = $matcherClass::$constantIDs;
                        
                        
                        # Skip over empties
                        if(empty($ids) === false) {
                            # print the matcher class name.
                            
                            $output->writeLn('<comment>'.$matcher . "UserAgentMatcher".'</comment>');
                            # print the path to the file                        
                            $output->writeLn('<info>inc</info> '.$file);
                                                        
                            # ouput the device list
                            foreach($ids as $an_id) {
                                $output->writeLn('<info>Device ID:</info> '.$an_id);    
                            }
                            
                            $output->writeLn('');    
                        }
                        
                    }
                    
                    break;
                case "constIDunique":
                    
                    $matcherList = UserAgentFactory::$matchers;
                    $ids = array();
                    
                    foreach ($matcherList as $matcher) {
                        $matcherClass = $matcher . "UserAgentMatcher";
                        $file = $base->rootdir . "UserAgentMatchers/{$matcherClass}.php";
                        require_once($file);
                        $matcherClass = '\\'.$matcherClass; 
                    
                        $ids = array_merge($ids, $matcherClass::$constantIDs);
                    }
                    
                    $output->writeLn('<info>Unique Device Id\'s</info>');
                    $ids = array_unique($ids);
                    sort($ids);
                    $output->writeLn(implode("\n", $ids));
                    break;
                case "createProcs":
                    
                    $output->writeLn("Recreating Procedures");
                    
                        $base->db->createProcedures();
                    
                    $output->writeLn("Done");
                    
                    break;
                case "benchmark":
                    
                    $quiet = true;
                    
                case "batchLookup":
                    
                    if($file_argument === false) {
                        throw new WURFLExtensionException('Missing file Argument');
                    }
                    
                    $fh = fopen($file_argument, 'r');
                    $i = 0;
                    $start = microtime(true);
                    
                    while (($ua = fgets($fh, 258)) !== false) {
                        $ua = rtrim($ua);
                        $base->getDeviceCapabilitiesFromAgent($ua);
                        if (!$quiet) {
                            $output->writeLn($ua);
                            $output->writeLn($base->capabilities['id'] . ": " . $base->capabilities['product_info']['brand_name'] . " " . $base->capabilities['product_info']['model_name']);
                            $output->writeLn('');
                        }
                        $i++;
                    }
                    
                    fclose($fh);
                    
                    $duration = microtime(true) - $start;
                    $speed = round($i / $duration, 2);
                    
                    $output->writeLn("<comment>--------------------------</comment>");
                    $output->writeLn("Tested <info> $i </info> devices in <info>$duration</info> sec ($speed/sec)");
                    
                    if (!$quiet) {
                        $output->writeLn("*printing the UAs is very time-consuming, use wurfl:stats for accurate speed testing");
                    }
                    
                    break;
                case "batchLookupFallback":
                    
                    if($file_argument === false) {
                        throw new WURFLExtensionException('Missing file Argument');
                    }
                    
                    $ids = file($file_argument, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                    
                    foreach ($ids as $id) {
                    
                        $fallback = array();
                        
                        if ($base->db->db_implements_fallback) {
                            
                            $tree = $base->db->getDeviceFallBackTree($id);
                            
                            foreach ($tree as $node) {
                                $fallback[] = $node['id'];
                            }
                            
                        } else {
                            new WURFLExtensionException('Unsupported on this platform');  
                        }
                        
                        pake_echo(implode(', ', $fallback));
                    }
                    break;
                    
                  default:
                        throw new WURFLExtensionException('Action for argument::'.$command.' not found');
                  break;    
            }
    
            parent::execute($input,$output);
        
        }
        
        
         protected function configure() {

         $this->setName('wurfl:debug')
              ->setDescription('Debug Functions used in testing')
              ->setHelp(<<<EOF
Some <info>Debug function</info> used in testing

Example:

<comment>Will display fallback devices for a UA, given a file of UA strings one per line</comment>
>> install.php wurfl:debug batchLookupFallback devices.txt

<comment>Display return data for a batch of UA given in a file one per line</comment>
>> install.php wurfl:debug batchLookup devices.txt

<comment>Run the wurfl function that create stored procedures </comment>
>> install.php wurfl:debug createProcs

<comment>display the id used in the device matchers by group </comment>
>> install.php wurfl:debug constIDgrouped


EOF
                 )->addArgument('action',
                    InputArgument::REQUIRED,
                    'debug action to take',
                    null
                )->addArgument('file',
                    InputArgument::OPTIONAL,
                    'a file to use a full path',
                    false
                );
        
        
        parent::configure();
    }    

}
/* End of File */
