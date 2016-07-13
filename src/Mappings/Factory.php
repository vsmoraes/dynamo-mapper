<?php
namespace Vsmoraes\DynamoMapper\Mappings;

use ICanBoogie\Inflector;
use Vsmoraes\DynamoMapper\Exception\InvalidAttributeType;

class Factory
{
    const DEFAULT_NAMESPACE = '\Vsmoraes\DynamoMapper\Mappings';

    /**
     * @param string $type
     * @return Mapping
     * @throws InvalidAttributeType
     */
    public function make(string $type): Mapping
    {
        if ($mapClass = $this->isDefaultMapping($type)) {
            return new $mapClass;
        }

        $customMapping = $this->getCustomMapping($type);
        if (!is_null($customMapping) && $customMapping instanceof Mapping) {
            return $customMapping;
        }

        throw new InvalidAttributeType("The attribute type '{$type}' is not supported");
    }

    /**
     * @param string $type
     * @return string|null
     */
    protected function isDefaultMapping(string $type)
    {
        $className = sprintf(
            '%s\%sMapping',
            static::DEFAULT_NAMESPACE,
            Inflector::get()->camelize($type)
        );

        return class_exists($className) ? $className : null;
    }

    /**
     * You can extend this class and override this method
     * to make your own custom mappings
     *
     * @see StringMapping for an example
     *
     * @param string $type
     * @return mixed|null
     */
    public function getCustomMapping($type)
    {
        return null;
    }
}
