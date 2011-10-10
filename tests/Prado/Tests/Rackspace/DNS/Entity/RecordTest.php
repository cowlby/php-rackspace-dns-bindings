<?php

namespace Prado\Tests\Rackspace\DNS\Entity;

use DateTime;
use Prado\Rackspace\DNS\Entity\Record;

/**
 * Record test case.
 */
class RecordTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Prado\Rackspace\DNS\Entity\Record
     */
    private $record;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        $this->record = new Record;
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->record = null;
    }
    
    public function testGettersAndSetters()
    {
        $fields = array('id', 'type', 'name', 'data', 'priority', 'ttl', 'updated', 'created');
        
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
            
            $this->record->$setter($value);
            $this->assertEquals($value, $this->record->$getter());
        }
    }
}
