<?php
namespace Vsmoraes\DynamoMapper;

use Fixtures\Person;

class MapperTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldBuildEntityWithDataArray()
    {
        $data = [
            'id' => ['N' => '1'],
            'name' => ['S' => 'Foo'],
            'gender' => ['S' => 'male'],
        ];

        $entity = (new Mapper())->getFilledEntity(new Person(), $data);

        $this->assertEquals(1, $entity->getId());
        $this->assertEquals('Foo', $entity->getName());
        $this->assertEquals('male', $entity->gender);
    }

    public function testShouldBuildArrayDataFromEntities()
    {
        $entity1 = (new Person())->setId(1)
            ->setName('Foo');
        $entity1->gender = 'male';

        $expected = [
            'id' => ['N' => 1],
            'name' => ['S' => 'Foo'],
            'gender' => ['S' => 'male'],
        ];

        $result = (new Mapper())->getEntityDate($entity1);

        $this->assertEquals($expected, $result);
    }
}
