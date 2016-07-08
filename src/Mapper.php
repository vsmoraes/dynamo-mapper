<?php
namespace Dynamo\Mapper;

use Dynamo\Mapper\Exception\InvalidAttributeType;
use ICanBoogie\Inflector;

class Mapper
{
    /**
     * DynamoDb result node
     */
    const ITEMS_NODE = 'Items';

    /**
     * Map types
     */
    const MAP = [
        'string' => 'S',
        'int' => 'N',
        'array' => 'SS'
    ];

    /**
     * @var mixed $entityClass
     */
    protected $entityClass;

    /**
     * @var array $data
     */
    protected $data;

    /**
     * @var \ReflectionClass $reflectionClass
     */
    protected $reflectionClass;

    /**
     * @param mixed $entityClass
     * @return Mapper
     */
    public function setEntityClass($entityClass): Mapper
    {
        $this->entityClass = $entityClass;
        $this->reflectionClass = new \ReflectionClass($entityClass);

        return $this;
    }

    /**
     * @param array $data
     * @return Mapper
     */
    public function setData(array $data): Mapper
    {
        if (! array_key_exists(static::ITEMS_NODE, $data)) {
            throw new \InvalidArgumentException('No entry "Items" found.');
        }

        $this->data = $data[static::ITEMS_NODE];

        return $this;
    }

    /**
     * @return array
     * @throws Exception\AnnotationNotFound
     * @throws Exception\InvalidAttributeType
     */
    public function getMappedEntity(): array
    {
        $annotations = new Annotations($this->reflectionClass);

        $entities = [];

        foreach ($this->data as $record) {
            $entity = clone $this->entityClass;

            foreach ($record as $field => $data) {
                $type = $annotations->getAttributeType($field);
                $value = $this->getFieldValue($data, $type);

                $this->setEntityValue($entity, $field, $value);
            }

            $entities[] = $entity;
        }

        return $entities;
    }

    /**
     * @param mixed $entity
     * @param string $field
     * @param mixed $value
     */
    protected function setEntityValue($entity, $field, $value)
    {
        $method = Inflector::get()->camelize('set_' . $field);

        if (method_exists($entity, $method)) {
            $entity->{$method}($value);
            return;
        }

        if (property_exists($this->entityClass, $field)) {
            $entity->{$field} = $value;
            return;
        }
    }

    /**
     * @param array $data
     * @param string $type
     * @return string
     * @throws InvalidAttributeType
     */
    protected function getFieldValue(array $data, string $type): string
    {
        if (! array_key_exists($type, static::MAP)) {
            throw new InvalidAttributeType;
        }

        return $data[static::MAP[$type]];
    }
}
