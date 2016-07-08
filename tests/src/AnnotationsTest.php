<?php
namespace Dynamo\Mapper;

use Dynamo\Mapper\Exception\AnnotationNotFound;
use Dynamo\Mapper\Exception\InvalidAttributeType;

class AnnotationsTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldGetAttributeTypes()
    {
        $fakeClass = new class {
            /**
             * @var int $attribute1
             */
            public $attribute1 = 1;

            /**
             * @var string $attribute2
             */
            public $attribute2 = 'test';

            /**
             * @var array $attribute3
             */
            public $attribute3 = [1, 2, 3];
        };

        $annotations = new Annotations(new \ReflectionClass($fakeClass));

        $this->assertEquals('int', $annotations->getAttributeType('attribute1'));
        $this->assertEquals('string', $annotations->getAttributeType('attribute2'));
        $this->assertEquals('array', $annotations->getAttributeType('attribute3'));
    }

    public function testShouldThrowAnnotationNotFound()
    {
        $this->expectException(AnnotationNotFound::class);

        $fakeClass = new class {
            /**
             * @foo
             */
            public $attribute1 = 1;
        };

        $annotations = new Annotations(new \ReflectionClass($fakeClass));
        $annotations->getAttributeType('attribute1');
    }

    public function testShouldThrowInvalidAttributeType()
    {
        $this->expectException(InvalidAttributeType::class);

        $fakeClass = new class {
            /**
             * @var foo $attribute1
             */
            public $attribute1 = 1;
        };

        $annotations = new Annotations(new \ReflectionClass($fakeClass));
        $annotations->getAttributeType('attribute1');
    }
}
