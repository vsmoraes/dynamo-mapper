<?php
namespace Vsmoraes\DynamoMapper;

use Fixtures\Person;
use Vsmoraes\DynamoMapper\Exception\AttributeUnreachable;
use Vsmoraes\DynamoMapper\Mappings\Factory;

class EntityMapTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldGetEntityFromData()
    {
        $id = 1;
        $name = 'Foo';
        $gender = 'Bar';
        $active = false;

        $data = [
            'id' => ['N' => "$id"],
            'name' => ['S' => $name],
            'gender' => ['S' => $gender],
            'active' => ['BOOL' => $active]
        ];

        $expectedEntity = (new Person())->setId($id)
            ->setName($name)
            ->setActive($active);
        $expectedEntity->gender = $gender;

        $entityMap = new EntityMap(new Person(), $data, new Factory());
        $result = $entityMap->getMap();

        $this->assertEquals($expectedEntity, $result);
    }

    public function testUnreacheableAttribute()
    {
        $this->expectException(AttributeUnreachable::class);

        $data = [
            'unreachable' => ['N' => '1']
        ];

        $entity = new Class {
            /**
             * @var int $unreachable
             */
            private $unreachable;
        };

        $entityMap = new EntityMap(new $entity(), $data, new Factory());
        $entityMap->getMap();
    }
}
