<?php

namespace Prado\Rackspace\DNS;

use DateTime;
use Prado\Rackspace\DNS\Model\Entity;

class Hydrator
{
    public function hydrateEntity(Entity $entity, $json)
    {
        foreach ($entity->getFields() as $field) {
            if (isset($json[$field])) {
                
                $set = sprintf('set%s', ucfirst($field));
                switch ($field) {
                    
                    case 'created':
                    case 'updated':
                        $entity->$set(new DateTime($json[$field]));
                        break;
                        
                    default:
                        $entity->$set($json[$field]);
                        break;
                }
                
            }
        }
    }
}
