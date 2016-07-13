<?php
namespace Vsmoraes\DynamoMapper\Mappings;

class BoolMapping implements Mapping
{
    /**
     * {@inheritdoc}
     */
    public function toAttribute(array $data)
    {
        return (bool) $data['BOOL'];
    }

    /**
     * {@inheritdoc}
     */
    public function toArray($value): array
    {
        return ['BOOL' => (bool) $value];
    }
}
