<?php
namespace Dynamo\Mapper;

use Dynamo\Mapper\Exception\InvalidAttributeType;
use ICanBoogie\Inflector;

class Mapper
{
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
     * @var array
     */
    protected $entities;

    /**
     * @param mixed $entityClass
     * @return Mapper
     */
    public function setEntityClass($entityClass): Mapper
    {
        $this->entityClass = $entityClass;

        return $this;
    }

    /**
     * @param array $data
     * @return Mapper
     */
    public function setData(array $data): Mapper
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return array
     * @throws Exception\AnnotationNotFound
     * @throws Exception\InvalidAttributeType
     */
    public function getMappedEntity(): array
    {
        $reflectionClass = new \ReflectionClass($this->entityClass);
        $annotations = new Annotations($reflectionClass);

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
     * @return array
     */
    public function getData(): array
    {
        $data = [];

        foreach ($this->entities as $entity) {
            $item = $this->getEntityAttributes($entity);

            $data[] = $item;
        }

        return $data;
    }

    /**
     * @param $entity
     * @return array
     * @throws Exception\AnnotationNotFound
     * @throws InvalidAttributeType
     */
    protected function getEntityAttributes($entity): array
    {
        $reflectionClass = new \ReflectionClass($entity);
        $properties = $reflectionClass->getProperties();
        $annotations = new Annotations($reflectionClass);

        $data = [];

        foreach ($properties as $property) {
            $type = $annotations->getAttributeType($property->getName());
            $value = $this->getEntityValue($entity, $property->getName());

            $data[$property->getName()] = [
                self::MAP[$type] => $value
            ];
        }


        return $data;
    }

    /**
     * @param array $entities
     * @return Mapper
     */
    public function setEntities(array $entities): Mapper
    {
        $this->entities = $entities;

        return $this;
    }

    /**
     * @param mixed $entity
     * @param string $field
     * @return mixed
     */
    protected function getEntityValue($entity, $field)
    {
        $method = Inflector::get()->camelize('get_' . $field);

        if (method_exists($entity, $method)) {
            return $entity->{$method}();
        }

        if (property_exists($entity, $field)) {
            return $entity->{$field};
        }
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

        if (property_exists($entity, $field)) {
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
