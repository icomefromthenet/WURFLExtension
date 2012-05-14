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

//---------------------------------------------------------------------
// Load The module
// 
//---------------------------------------------------------------------

return $di_container['module'];
/* End of File */