<?php
namespace Vsmoraes\DynamoMapper\Mappings;

class StringMappingTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldGetDataToSetIntoAttribute()
    {
        $data = ['S' => 'Foo'];
        $expected = 'Foo';

        $mapping = new StringMapping();

        $this->assertEquals($expected, $mapping->toAttribute($data));
    }

    public function testShouldGetDataToSendToDynamo()
    {
        $data = 'Foo';
        $expected = ['S' => 'Foo'];

        $mapping = new StringMapping();

        $this->assertEquals($expected, $mapping->toArray($data));
    }
}
