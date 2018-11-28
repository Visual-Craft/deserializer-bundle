<?php

namespace VisualCraft\ApiDeserializer\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use VisualCraft\ApiDeserializerBundle\ApiDeserializerBuilder;

class ApiDeserializerBuilderTest extends TestCase
{
    public function testGetDeserializer()
    {
        $deserializerBuilder = $this->getDeserializerBuilder();
        $deserializer = $deserializerBuilder->getDeserializer();

    }

    /**
     * @dataProvider getTestSetValidationGroupsExceptionsData
     */
    public function testSetValidationGroupsExceptions($validationGroups)
    {
        $deserializerBuilder = $this->getDeserializerBuilder();
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Validation groups should be array of strings or callable');
        $deserializerBuilder->setValidationGroups($validationGroups);
    }

    /**
     * @return array
     */
    public function getTestSetValidationGroupsExceptionsData(): array
    {
        return [
            [new \stdClass()],
            [1],
            ['string'],
        ];
    }

    /**
     * @return ApiDeserializerBuilder
     */
    private function getDeserializerBuilder(): ApiDeserializerBuilder
    {
        $serializer = $this->createMock(SerializerInterface::class);
        $validator = $this->createMock(ValidatorInterface::class);

        return new ApiDeserializerBuilder(\stdClass::class, $serializer, $validator);
    }
}
