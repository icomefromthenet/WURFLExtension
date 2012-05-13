<?php
namespace WURFLExtension\Command;

use WURFLExtension\Command\Base\Command,
    WURFLExtension\Exception as WURFLExtensionException,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Helper\DialogHelper,
    Symfony\Component\Console\Output\OutputInterface;

class Merge extends Command
{

    protected $answers;

    /**
     * Interacts with the user.
     *
     * @param InputInterface  $input  An InputInterface instance
     * @param OutputInterface $output An OutputInterface instance
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $dialog = new DialogHelper();
        $answers =  array();

        
        # Ask for the database type
        $answers['db_type'] =  strtolower($dialog->ask($output,'Which database does this <info>belong</info>? [mysql4|mysql5|mssql2005|mongodb]: ','mysql5'));
        $connector_options = array(
            'mysql4'    => 'MySQL4',
            'mysql5'    => 'MySQL5',
            'mssql2005' => 'MSSQL2005',
            'mongodb'   => 'MongoDB',
        );
        
        if(isset($answers['db_type']) === false) {
            throw new WURFLExtensionException('Unknown database connector::'.$answers['db_type']);
        }
        
        $answers['db_type'] = $connector_options[$answers['db_type']];
        
        # Ask Database Schema Name
        $answers['db_schema'] =  $dialog->ask($output,'What is the database <info>schema name</info>? [wurfl] : ','wurfl');

        #Database user Name
        $answers['db_user'] =  $dialog->ask($output,'What is the database <info>username</info>? : ');

        #Database user Password
        $answers['db_password'] =  $dialog->ask($output,'What is the database <info>users password</info>? : ');

        #Database host
        $answers['db_host'] =  $dialog->ask($output,'What is the database <info>host name</info>? [localhost] : ','localhost');

        # Store answers for the execute method
        $this->answers = $answers;

      
        return true;      
        
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $rootdir          =  WURFLEXTENSION_VENDOR_DIR.'/TeraWurfl';
        $config_template  = 'TeraWurflConfig.php.example';
        $config_file_name = 'TeraWurflConfig.php';
    
        
        # check if template config exists
        if(is_file($rootdir . '/'.$config_template) === false) {
            throw new WURFLExtension('TERAWurfl Config Template not found');
        }
    
        $output->writeln('<comment>Reading Template config</comment>');
        $template_content = file_get_contents($rootdir .'/'.$config_template);
    
        #replace the tokens with database config
    
        # host
        $template_content = str_replace('@host@', $this->answers['db_host'], $template_content);
        $output->writeln('<info>++Replace</info> Replacing Host');
    
        # username
        $template_content = str_replace('@username@', $this->answers['db_user'], $template_content);
        $output->writeln('<info>++Replace</info> Replacing Username');
    
    
        # password
        $template_content = str_replace('@password@', $this->answers['db_password'], $template_content);
        $output->writeln('<info>++Replace</info> Replacing Password');
    
    
        # schema
        $template_content = str_replace('@schema@', $this->answers['db_schema'], $template_content);
        $output->writeln('<info>++Replace</info> Replacing Scheam');
        
        # connector    
        $template_content = str_replace('@connector@', $this->answers['db_type'], $template_content);
        $output->writeln('<info>++Replace</info> Replacing the connector');
    
    
        # remove the existsing file
        if(is_file($rootdir .'/'.$config_file_name) === TRUE) {
            unlink($rootdir .'/'.$config_file_name);
            $output->writeln('<comment>Removed existing config file</comment>');
        }
    
        # write file
        if(file_put_contents($rootdir .'/'.$config_file_name, $template_content) === false){
            throw new WURFLExtensionException('unable to write new config file');
        }
    
        $output->writeln('<comment>Finished merge of database config</comment>');
            
        parent::execute($input,$output);
    
    }
    
    
    protected function configure() {

         $this->setName('wurfl:merge')
              ->setDescription('Will collection information for database connection')
              ->setHelp(<<<EOF
Will <info>collect database connection details</info> and merge them with TeraWurfl Config

Example:

<comment>Begin the questions </comment>
>> install.php wurfl:merge 


EOF
                 );
        
        
        parent::configure();
    }
    
    
    

}
/* End of File */
