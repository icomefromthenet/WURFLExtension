<?php
namespace WURFLExtension\Command;

use WURFLExtension\Command\Base\Command,
    WURFLExtension\Exception as WURFLExtensionException,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Helper\DialogHelper,
    Symfony\Component\Console\Output\OutputInterface;

class Stats extends Command
{
   
    protected function execute(InputInterface $input, OutputInterface $output)
    {

            $base = $this->getApplication()->getModule()->getContainer()->getTeraWurfl();

            $twversion = $base->release_branch . ' ' . $base->release_version;
            $wurflversion = $base->db->getSetting('wurfl_version');
            $lastupdated = date('r',$base->db->getSetting('loaded_date'));
            
            $config = $base->rootdir . "TeraWurflConfig.php";
            $dbtype = str_replace("TeraWurflDatabase_", "", get_class($base->db));
            
            
            $dbver = $base->db->getServerVersion();
            $mergestats = $base->db->getTableStats(TeraWurflConfig::$TABLE_PREFIX . 'Merge');
            $mergestats['bytesize'] = WurflSupport::formatBytes($mergestats['bytesize']);
            
            $merge = "\n > MERGE
                    Rows:    {$mergestats['rows']}
                    Devices: {$mergestats['actual_devices']}
                    Size:    {$mergestats['bytesize']}\n";
                    
            $index = "";
            $indexstats = $base->db->getTableStats(TeraWurflConfig::$TABLE_PREFIX . 'Index');
            
            if (!empty($indexstats)) {
                $indexstats['bytesize'] = WurflSupport::formatBytes($indexstats['bytesize']);
                
                $index = "\n > INDEX
                    Rows:    {$indexstats['rows']}
                    Size:    {$indexstats['bytesize']}\n";
            }
            
            $cachestats = $base->db->getTableStats(TeraWurflConfig::$TABLE_PREFIX . 'Cache');
            $cachestats['bytesize'] = WurflSupport::formatBytes($cachestats['bytesize']);
            
            $cache = "\n > CACHE
                Rows:    {$cachestats['rows']}
                Size:    {$cachestats['bytesize']}\n";
            
            $matcherList = $base->db->getMatcherTableList();
            $matchers = array();
            
            foreach ($matcherList as $name) {
                $matchers[] = array('name' => $name, 'stats' => $base->db->getTableStats($name));
            }
        
$out = <<<EOF
        Tera-WURFL $twversion
        Database Type: $dbtype (ver $dbver)
        Loaded WURFL: $wurflversion
        Last Updated: $lastupdated
        Config File: $config
        ---------- Table Stats -----------
        {$merge}{$index}{$cache}
EOF;
        
            $output->writeln($out);
            
            parent::execute($input,$output);
    
    }
    
    
    protected function configure() {

         $this->setName('wurfl:stats')
              ->setDescription('Fetch table stats, number of devices, size of the cache , version')
              ->setHelp(<<<EOF
Will print various stats information

Example:

<comment>Print stats information</comment>
>> install.php wurfl:stats

EOF
                 );
        
        
        parent::configure();
    }

}
/* End of File */