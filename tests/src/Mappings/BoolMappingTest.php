<?php
namespace Vsmoraes\DynamoMapper\Mappings;

class BoolMappingTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldGetDataToSetIntoAttribute()
    {
        $data = ['BOOL' => true];
        $expected = true;

        $mapping = new BoolMapping();

        $this->assertEquals($expected, $mapping->toAttribute($data));
    }

    public function testShouldGetDataToSendToDynamo()
    {
        $data = false;
        $expected = ['BOOL' => false];

        $mapping = new BoolMapping();

        $this->assertEquals($expected, $mapping->toArray($data));
    }
}
