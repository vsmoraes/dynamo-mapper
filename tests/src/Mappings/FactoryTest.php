<?php
namespace Vsmoraes\DynamoMapper\Mappings;

use Vsmoraes\DynamoMapper\Exception\InvalidAttributeType;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldMakeStringMapping()
    {
        $factory = new Factory();
        $mapping = $factory->make('string');

        $this->assertInstanceOf(StringMapping::class, $mapping);
    }

    public function testShouldThrowExceptionForInvalidTypes()
    {
        $this->expectException(InvalidAttributeType::class);

        $factory = new Factory();
        $factory->make('foo');
    }
}
