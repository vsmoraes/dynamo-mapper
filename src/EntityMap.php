<?php
namespace Vsmoraes\DynamoMapper;

use ICanBoogie\Inflector;
use Vsmoraes\DynamoMapper\Exception\InvalidAttributeType;

class EntityMap implements Map
{
    /**
     * @var mixed
     */
    private $entity;

    /**
     * @var array
     */
    private $data;

    /**
     * @var \ReflectionClass
     */
    protected $reflectionClass;

    public function __construct($entity, array $data)
    {
        $this->entity = $entity;
        $this->data = $data;
        $this->reflectionClass = new \ReflectionClass($this->entity);
    }

    public function getMap()
    {
        $entity = clone $this->entity;

        $annotations = new Annotations($this->reflectionClass);

        foreach ($this->data as $attribute => $value) {
            $type = $annotations->getAttributeType($attribute);
            $value = $this->getFieldValue($value, $type);

            $this->setEntityValue($entity, $attribute, $type, $value);
        }

        return $entity;
    }

    /**
     * @param array $data
     * @param string $type
     * @return string
     * @throws InvalidAttributeType
     */
    protected function getFieldValue(array $data, string $type): string
    {
        if (! array_key_exists($type, Mapper::MAP)) {
            throw new InvalidAttributeType;
        }

        return $data[Mapper::MAP[$type]];
    }

    /**
     * @param mixed $entity
     * @param string $field
     * @param string $type
     * @param mixed $value
     */
    protected function setEntityValue($entity, string $field, string $type, $value)
    {
        $method = Inflector::get()->camelize('set_' . $field);

        if ($type == '\datetimeinterface') {
            $value = new \DateTime($value);
        }

        if (method_exists($entity, $method)) {
            $entity->{$method}($value);
            return;
        }

        $property = new \ReflectionProperty($entity, $field);
        if ($property->isPublic()) {
            $entity->{$field} = $value;
        }
    }
}
