<?php
namespace Vsmoraes\DynamoMapper\Mappings;

use ICanBoogie\Inflector;
use Vsmoraes\DynamoMapper\Exception\InvalidAttributeType;

class Factory
{
    const DEFAULT_NAMESPACE = '\Vsmoraes\DynamoMapper\Mappings';

    /**
     * @param $type
     * @return Mapping
     * @throws InvalidAttributeType
     */
    public function make($type): Mapping
    {
        if ($mapClass = $this->isDefaultMapping($type)) {
            return new $mapClass;
        }

        throw new InvalidAttributeType("The attribute type '{$type}' is not supported");
    }

    /**
     * @param $type
     * @return string|null
     */
    protected function isDefaultMapping($type)
    {
        $className = sprintf(
            '%s\%sMapping',
            static::DEFAULT_NAMESPACE,
            Inflector::get()->camelize($type)
        );

        return class_exists($className) ? $className : null;
    }
}
