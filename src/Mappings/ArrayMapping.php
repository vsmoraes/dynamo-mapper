<?php
namespace Vsmoraes\DynamoMapper\Mappings;

class ArrayMapping implements Mapping
{
    /**
     * {@inheritdoc}
     */
    public function toAttribute(array $data)
    {
        return (array) $data['SS'];
    }

    /**
     * {@inheritdoc}
     */
    public function toArray($value): array
    {
        return ['SS' => (array) $value];
    }
}
