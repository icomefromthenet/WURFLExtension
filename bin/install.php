<?php
namespace WURFLExtension;

use WURFLExtension\Command\Cache,
    WURFLExtension\Command\Debug,
    WURFLExtension\Command\Download,
    WURFLExtension\Command\Install,
    WURFLExtension\Command\Merge,
    WURFLExtension\Command\Stats;


//----------------------------------------------------------
// Load the bootstrap get the module with dependency injector
//
//---------------------------------------------------------

$module = require __DIR__.'/../src/WURFLExtension/Bootstrap.php';


//----------------------------------------------------------
// Setup the Console Commands
//
//---------------------------------------------------------


$module->getContainer()->getConsole()->add(new Cache());
$module->getContainer()->getConsole()->add(new Debug());
$module->getContainer()->getConsole()->add(new Download());
$module->getContainer()->getConsole()->add(new Install());
$module->getContainer()->getConsole()->add(new Merge());
$module->getContainer()->getConsole()->add(new Stats());


//--------------------------------------------------------------------
// Run the App
//--------------------------------------------------------------------

$module->getContainer()->getConsole()->run();

/* End of File */