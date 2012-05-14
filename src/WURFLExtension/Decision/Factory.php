<?php
namespace WURFLExtension\Decision;

use WURFLExtension\Exception as WURFLExtensionException,
    Closure;

class Factory
{
    
    public function create($class,Closure $callback)
    {
        if(class_exists($class) === false) {
            throw new WURFLExtensionException('Decision Manager Class Does not exist');
        }
        
        $criteria  = $class::getCriteria();
        $strategy  = $class::getStrategy();
        
        return new $class($criteria,$strategy,$callback);
    }
    
    
}
/* End of File */