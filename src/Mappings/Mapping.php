<?php
namespace Vsmoraes\DynamoMapper\Mappings;

interface Mapping
{
    /**
     * Turn field value from DynamoDB into a raw value
     * to set into the entity
     *
     * @param array $data
     * @return mixed
     */
    public function toAttribute(array $data);

    /**
     * Turn a mixed value into a DynnamoDB field array
     *
     * @param mixed $value
     * @return array
     */
    public function toArray($value): array;
}
