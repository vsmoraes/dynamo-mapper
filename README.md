# DynamoDB Mapper

[![Build Status](https://img.shields.io/travis/vsmoraes/dynamo-mapper/master.svg?style=flat-square)](https://travis-ci.org/vsmoraes/dynamo-mapper)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/vsmoraes/dynamo-mapper/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/vsmoraes/dynamo-mapper/?branch=master)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/vsmoraes/dynamo-mapper/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/vsmoraes/dynamo-mapper/?branch=master)
[![HHVM](https://img.shields.io/hhvm/vsmoraes/dynamo-mapper.svg?style=flat-square)](https://travis-ci.org/vsmoraes/dynamo-mapper)
[![Latest Stable Version](https://img.shields.io/packagist/v/vsmoraes/dynamo-mapper.svg?style=flat-square)](https://packagist.org/packages/vsmoraes/dynamo-mapper)
[![Total Downloads](https://img.shields.io/packagist/dt/vsmoraes/dynamo-mapper.svg?style=flat-square)](https://packagist.org/packages/vsmoraes/dynamo-mapper)
[![License](https://img.shields.io/packagist/l/vsmoraes/dynamo-mapper.svg?style=flat-square)](https://packagist.org/packages/vsmoraes/dynamo-mapper)

A simple wrapper so you can use your own entities with dynamodb

## Instalation
The package is available on [Packagist](http://packagist.org/packages/vsmoraes/dynamo-mapper).
Autoloading is [PSR-4](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md) compatible.

```composer require vsmoraes/dynamo-mapper```

Or add it directly to you `composer.json` file

```json
{
    "require": {
        "vsmoraes/dynamo-mapper": "dev-master"
    }
}
```

## Usage

```php
$data = [
    'id' => ['N' => '1'],
    'name' => ['S' => 'Foo'],
    'gender' => ['S' => 'male'],
    'active' => ['BOOL' => true]
];

$entity = (new Mapper(new Factory()))->getFilledEntity(new Person(), $data);
```

```php
$entity = (new Person())->setId(1)
    ->setName('Foo');
$entity->gender = 'male';

$dynamoEntry = (new Mapper(new Factory()))->getEntityDate($entity);
```

## License

MIT License
