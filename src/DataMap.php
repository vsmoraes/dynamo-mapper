<?php
namespace Vsmoraes\DynamoMapper;

use ICanBoogie\Inflector;
use Vsmoraes\DynamoMapper\Mappings\Factory;

class DataMap implements Map
{
    /**
     * @var mixed
     */
    private $entity;

    /**
     * @var Factory
     */
    private $mappingFactory;

    public function __construct($entity, Factory $mappingFactory)
    {
        $this->entity = $entity;
        $this->mappingFactory = $mappingFactory;
    }

    /**
     * @return mixed
     */
    public function getMap()
    {
        $reflectionClass = new \ReflectionClass($this->entity);
        $properties = $reflectionClass->getProperties();
        $annotations = new Annotations($reflectionClass);

        $data = [];

        foreach ($properties as $property) {
            $type = $annotations->getAttributeType($property->getName());
            $value = $this->getEntityValue($property->getName());

            $data[$property->getName()] = $this->mappingFactory->make($type)
                ->toArray($value);
        }


        return $data;
    }

    /**
     * @param string $field
     * @return mixed
     */
    protected function getEntityValue($field)
    {
        $method = Inflector::get()->camelize('get_' . $field);

        if (method_exists($this->entity, $method)) {
            return $this->entity->{$method}();
        }

        $boolMethod = Inflector::get()->camelize('is_' . $field);

        if (method_exists($this->entity, $boolMethod)) {
            return $this->entity->{$boolMethod}();
        }

        $property = new \ReflectionProperty($this->entity, $field);
        if ($property->isPublic()) {
            return $this->entity->{$field};
        }
    }
}
