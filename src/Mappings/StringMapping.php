<?php
namespace Vsmoraes\DynamoMapper\Mappings;

class StringMapping implements Mapping
{
    /**
     * {@inheritdoc}
     */
    public function toAttribute(array $data)
    {
        return (string) $data['S'];
    }

    /**
     * {@inheritdoc}
     */
    public function toArray($value): array
    {
        return ['S' => $value];
    }
}
