<?php
namespace Vsmoraes\DynamoMapper;

use Vsmoraes\DynamoMapper\Mappings\Factory;

class Mapper
{
    /**
     * @var Factory
     */
    private $mappingFactory;

    public function __construct(Factory $mappingFactory)
    {
        $this->mappingFactory = $mappingFactory;
    }

    public function getFilledEntity($entity, array $data)
    {
        return (new EntityMap($entity, $data, $this->mappingFactory))->getMap();
    }

    public function getEntityDate($entity)
    {
        return (new DataMap($entity, $this->mappingFactory))->getMap();
    }
}
