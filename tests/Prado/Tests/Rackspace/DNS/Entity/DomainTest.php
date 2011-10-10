<?php

namespace Prado\Tests\Rackspace\DNS\Entity;

use DateTime;
use Prado\Rackspace\DNS\Entity\Domain;

/**
 * Domain test case.
 */
class DomainTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Prado\Rackspace\DNS\Entity\Domain
     */
    private $domain;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        $this->domain = new Domain;
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->domain = null;
    }
    
    public function testGettersAndSetters()
    {
        $fields = array('id', 'accountId', 'name', 'comment', 'ttl', 'emailAddress', 'contentType', 'content', 'updated', 'created');
        
        foreach ($fields as $field) {
            
            $getter = sprintf('get%s', ucfirst($field));
            $setter = sprintf('set%s', ucfirst($field));
            
            switch ($field) {
                
                case 'created':
                case 'updated':
                    $value = new DateTime;
                    break;
                    
                default:
                    $value = 'value1';
                    break;
            }
            
            $this->domain->$setter($value);
            $this->assertEquals($value, $this->domain->$getter());
        }
    }
}
