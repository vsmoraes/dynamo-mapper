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

    public function testShouldPermitCustomMappings()
    {
        $customMapping = new Class implements Mapping {
            public function toAttribute(array $data)
            {
                return 'Bar';
            }

            public function toArray($value): array
            {
                return ['Bar'];
            }
        };

        $factory = $this->getMockBuilder(Factory::class)
            ->setMethods(['getCustomMapping'])
            ->getMock();
        
        $factory->expects($this->once())
            ->method('getCustomMapping')
            ->will($this->returnValue($customMapping));

        $result = $factory->make('foo');

        $this->assertInstanceOf(Mapping::class, $result);
        $this->assertEquals($customMapping, $result);
    }
}
