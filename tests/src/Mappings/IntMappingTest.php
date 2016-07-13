<?php
namespace Vsmoraes\DynamoMapper\Mappings;

class IntMappingTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldGetDataToSetIntoAttribute()
    {
        $data = ['N' => '1'];
        $expected = 1;

        $mapping = new IntMapping();

        $this->assertEquals($expected, $mapping->toAttribute($data));
    }

    public function testShouldGetDataToSendToDynamo()
    {
        $data = 1;
        $expected = ['N' => '1'];

        $mapping = new IntMapping();

        $this->assertEquals($expected, $mapping->toArray($data));
    }
}
