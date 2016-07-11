<?php
namespace Dynamo\Mapper;

use Dynamo\Mapper\Exception\AnnotationNotFound;
use Dynamo\Mapper\Exception\InvalidAttributeType;

class Annotations
{
    const AVAILABLE_TYPES = ['int', 'string', 'array', 'bool', '\datetimeinterface'];

    /**
     * @var \ReflectionClass
     */
    private $reflectionClass;

    public function __construct(\ReflectionClass $reflectionClass)
    {
        $this->reflectionClass = $reflectionClass;
    }

    /**
     * @param string $attribute
     * @return string
     * @throws AnnotationNotFound
     * @throws InvalidAttributeType
     */
    public function getAttributeType(string $attribute): string
    {
        $docblock = $this->reflectionClass->getProperty($attribute)
            ->getDocComment();

        $annotations = [];
        preg_match_all('/@var\s+(\\\?\w+)/', $docblock, $annotations, PREG_SET_ORDER);

        if (empty($annotations) || ! isset($annotations[0][1])) {
            throw new AnnotationNotFound;
        }

        $type = strtolower($annotations[0][1]);

        if (! in_array($type, self::AVAILABLE_TYPES)) {
            var_dump($type);die;
            throw new InvalidAttributeType;
        }

        return $type;
    }
}
