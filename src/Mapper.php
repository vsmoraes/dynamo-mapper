<?php
namespace Vsmoraes\DynamoMapper;

use Vsmoraes\DynamoMapper\Exception\InvalidAttributeType;
use ICanBoogie\Inflector;

class Mapper
{
    /**
     * Map types
     */
    const MAP = [
        'string' => 'S',
        'int' => 'N',
        'array' => 'SS',
        'bool' => 'BOOL',
        '\datetimeinterface' => 'S'
    ];

    /**
     * @var array
     */
    protected $entities;

    public function getFilledEntity($entity, array $data)
    {
        return (new EntityMap($entity, $data))->getMap();
    }

    public function getEntityDate($entity)
    {
        return (new DataMap($entity))->getMap();
    }
}
