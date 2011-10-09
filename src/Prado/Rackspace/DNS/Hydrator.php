<?php

namespace Prado\Rackspace\DNS;

use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

use stdClass;
use DateTime;
use ReflectionMethod;
use ReflectionObject;
use Prado\Rackspace\DNS\Entity;

class Hydrator
{
    /**
     * Hydrates an Entity by comparing its setter methods to an assosciative
     * array of data and filling in the data that matches.
     * 
     * @param Prado\Rackspace\DNS\Model\Entity $entity The Entity to hydrate
     * @param array $data The data to hydrate Entity with
     */
    public function hydrateEntity(Entity $entity, $data)
    {
        foreach ($this->getSetMethods($entity) as $method) {
            
            $attribute = $this->getAttributeName($method);
            if (isset($data[$attribute])) {
                
                switch ($attribute) {
                    
                    case 'created':
                    case 'updated':
                        $value = new DateTime($data[$attribute]);
                        break;
                        
                    default:
                        $value = $data[$attribute];
                        break;
                }
                
                $method->invoke($entity, $value);
            }
        }
    }
    
    /**
     * Returns an array of all the setter methods of an object.
     * 
     * @param object $entity The object to evaulate
     * @return array The setter methods of the object
     */
    public function getSetMethods($entity)
    {
        $object  = new ReflectionObject($entity);
        
        $methods = array();
        foreach ($object->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            if ($this->isSetMethod($method)) {
                $methods[] = $method;
            }
        }
        
        return $methods;
    }
    
    /**
     * Gets the attribute name of a setter method. Assumes that the method
     * passed in is a known set* method.
     * 
     * @param ReflectionMethod $method The method to get attribute name from
     * @return string The attribute name
     */
    public function getAttributeName(ReflectionMethod $method)
    {
        return lcfirst(substr($method->getName(), 3));
    }
    
    /**
     * Checks to see whether a given method is a setter method.
     * 
     * @param ReflectionMethod $method The ReflectionMethod to test
     * @return Boolean Whether or not method is a setter method
     */
    public function isSetMethod(ReflectionMethod $method)
    {
        $name = $method->getName();
        
        return (
            0 === strpos($name, 'set') &&
            3 < strlen($name) &&
            ctype_upper(substr($name, 3, 1))
        );
    }
}
