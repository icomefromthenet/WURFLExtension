<?php
namespace WURFLExtension\Decision;

use WURFLExtension\Exception as WURFLExtensionException;

class Factory
{
    
    public function create($class)
    {
        if(class_exists($class) === false) {
            throw new WURFLExtensionException('Decision Manager Class Does not exist');
        }
        
        $criteria  = $class::getCriteria();
        $strategy  = $class::getStrategy();
        
        return new $class($criteria,$strategy);
    }
    
    
}
/* End of File */