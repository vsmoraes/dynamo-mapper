<?php
namespace Vsmoraes\DynamoMapper\Mappings;

class ArrayMappingTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldGetDataToSetIntoAttribute()
    {
        $data = ['SS' => [1, 2, 3]];
        $expected = [1, 2, 3];

        $mapping = new ArrayMapping();

        $this->assertEquals($expected, $mapping->toAttribute($data));
    }

    public function testShouldGetDataToSendToDynamo()
    {
        $data = [1, 2, 3];
        $expected = ['SS' => [1, 2, 3]];

        $mapping = new ArrayMapping();

        $this->assertEquals($expected, $mapping->toArray($data));
    }
}
