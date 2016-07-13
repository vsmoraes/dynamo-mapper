<?php
namespace Vsmoraes\DynamoMapper;

use ICanBoogie\Inflector;
use Vsmoraes\DynamoMapper\Exception\AttributeUnreachable;
use Vsmoraes\DynamoMapper\Exception\InvalidAttributeType;
use Vsmoraes\DynamoMapper\Mappings\Factory;

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

    /**
     * @var Factory
     */
    protected $mappingFactory;

    public function __construct($entity, array $data, $mappingFactory)
    {
        $this->entity = $entity;
        $this->data = $data;
        $this->mappingFactory = $mappingFactory;
        $this->reflectionClass = new \ReflectionClass($this->entity);
    }

    public function getMap()
    {
        $entity = clone $this->entity;

        $annotations = new Annotations($this->reflectionClass);

        foreach ($this->data as $attribute => $value) {
            $type = $annotations->getAttributeType($attribute);
            $value = $this->getFieldValue($value, $type);

            $this->setEntityValue($entity, $attribute, $value);
        }

        return $entity;
    }

    /**
     * @param array $data
     * @param string $type
     * @return mixed
     * @throws InvalidAttributeType
     */
    protected function getFieldValue(array $data, string $type)
    {
        return $this->mappingFactory->make($type)
            ->toAttribute($data);
    }

    /**
     * @param mixed $entity
     * @param string $field
     * @param mixed $value
     * @throws AttributeUnreachable
     */
    protected function setEntityValue($entity, string $field, $value)
    {
        $method = Inflector::get()->camelize('set_' . $field);

        if (method_exists($entity, $method)) {
            $entity->{$method}($value);
            return;
        }

        $property = new \ReflectionProperty($entity, $field);
        if ($property->isPublic()) {
            $entity->{$field} = $value;
            return;
        }

        throw new AttributeUnreachable("Cannot access the attribute: '{$field}'");
    }
}
