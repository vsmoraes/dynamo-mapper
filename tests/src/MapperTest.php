<?php
namespace Dynamo\Mapper;

use Fixtures\Person;

class MapperTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldBuildEntityWithDataArray()
    {
        $data = [
            'Items' => [
                [
                    'id' => ['N' => '1'],
                    'name' => ['S' => 'Foo'],
                    'gender' => ['S' => 'male'],
                ],
                [
                    'id' => ['N' => '2'],
                    'name' => ['S' => 'Bar'],
                    'gender' => ['S' => 'female'],
                ],
            ],
            'Count' => 2,
            'ScannedCount' => 2,
            '@metadata' => []
        ];

        $entities = (new Mapper())->setEntityClass(new Person)
            ->setData($data)
            ->getMappedEntity();

        $this->assertCount(2, $entities);

        $result1 = $entities[0];
        $result2 = $entities[1];

        $this->assertEquals(1, $result1->getId());
        $this->assertEquals('Foo', $result1->getName());
        $this->assertEquals('male', $result1->gender);

        $this->assertEquals(2, $result2->getId());
        $this->assertEquals('Bar', $result2->getName());
        $this->assertEquals('female', $result2->gender);
    }
}
