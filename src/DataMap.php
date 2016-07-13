<?php
namespace Vsmoraes\DynamoMapper;

use ICanBoogie\Inflector;

class DataMap implements Map
{
    /**
     * @var mixed
     */
    private $entity;

    public function __construct($entity)
    {
        $this->entity = $entity;
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

            if ($type == '\datetimeinterface') {
                $value = $value->format(\DateTime::RFC3339);
            }

            $data[$property->getName()] = [
                Mapper::MAP[$type] => $value
            ];
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
