<?php
namespace Vsmoraes\DynamoMapper\Mappings;

class IntMapping implements Mapping
{
    /**
     * {@inheritdoc}
     */
    public function toAttribute(array $data)
    {
        return (int) $data['N'];
    }

    /**
     * {@inheritdoc}
     */
    public function toArray($value): array
    {
        return ['N' => $value];
    }
}
