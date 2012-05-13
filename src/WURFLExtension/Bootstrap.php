<?php
namespace WURFLExtension;

use Symfony\Component\ClassLoader\UniversalClassLoader;


//---------------------------------------------------------------------
// Regsiter some path constants
// 
//---------------------------------------------------------------------

define('WURFLEXTENSION_VENDOR_DIR',realpath(__DIR__.'/Vendor'));
define('WURFLEXTENSION_CLASS_DIR',realpath(__DIR__.'/..'));
define('WURFLEXTENSION_COMMAND_DIR',realpath(__DIR__.'/Command'));


//---------------------------------------------------------------------
// Regsiter the autoloader
// 
//---------------------------------------------------------------------

if(!class_exists('Symfony\Component\Class\UniversalClassLoader')) {
 require (__DIR__ .'/Vendor/Symfony/Component/ClassLoader/UniversalClassLoader.php'); 
}


$wurlf_extension_autoloader = new UniversalClassLoader();

$wurlf_extension_autoloader->registerNamespace('Symfony'         , WURFLEXTENSION_VENDOR_DIR);
$wurlf_extension_autoloader->registerNamespace('WURFLExtension'  , WURFLEXTENSION_CLASS_DIR);
$wurlf_extension_autoloader->useIncludePath(true);
$wurlf_extension_autoloader->register(); 

 
 

//---------------------------------------------------------------------
// Register the di container
// 
//---------------------------------------------------------------------

$di_container = new Container(); 


$di_container['tera_wurfl'] = $di_container->share(function($container){

     #Include Files need for Wurfl

    $TeraWurfl_PATH = WURFLEXTENSION_VENDOR_DIR .'/TeraWurfl/';
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

$di_container['console'] = $di_container->share(function($container){
    return new \WURFLExtension\Command\Base\Application($container['module']);
});

$di_container['module']  = $di_container->share(function($container){
    return new \WURFLExtension\Module($container);
});

$di_container['tera_wurfl_wrapper'] = $di_container->share(function($container){
    return new \WURFLExtension\TerraWurflWrapper($container['tera_wurfl']);
});

//---------------------------------------------------------------------
// Load The module
// 
//---------------------------------------------------------------------

return $di_container['module'];
/* End of File */