<?php
namespace Vsmoraes\DynamoMapper;

use Fixtures\Person;
use Vsmoraes\DynamoMapper\Exception\AttributeUnreachable;
use Vsmoraes\DynamoMapper\Mappings\Factory;

class DataMapTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldGetDataFromEntity()
    {
        $id = 1;
        $name = 'Foo';
        $gender = 'Bar';
        $active = false;

        $entity = (new Person())->setId($id)
            ->setName($name)
            ->setActive($active);
        $entity->gender = $gender;

        $expected = [
            'id' => ['N' => $id],
            'name' => ['S' => $name],
            'gender' => ['S' => $gender],
            'active' => ['BOOL' => $active]
        ];

        $dataMap = new DataMap($entity, new Factory());
        $result = $dataMap->getMap();

        $this->assertEquals($expected, $result);
    }

    public function testUnreacheableAttribute()
    {
        $this->expectException(AttributeUnreachable::class);

        $entity = new Class {
            /**
             * @var int $unreachable
             */
            private $unreachable = 1;
        };

        $dataMap = new DataMap($entity, new Factory());
        $dataMap->getMap();
    }
}
