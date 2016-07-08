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
    }
}
