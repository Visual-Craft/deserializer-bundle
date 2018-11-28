<?php

namespace VisualCraft\ApiDeserializerBundle\Tests;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use VisualCraft\ApiDeserializerBundle\ApiDeserializer;
use VisualCraft\ApiDeserializerBundle\ApiDeserializerBuilder;
use VisualCraft\ApiDeserializerBundle\Test\PHPUnit\Framework\TestCase;

class ApiDeserializerBuilderTest extends TestCase
{
    public function testGetDeserializer(): void
    {
        $deserializerBuilder = $this->getDeserializerBuilder();
        $deserializer = $deserializerBuilder->getDeserializer();

        static::assertInstanceOf(ApiDeserializer::class, $deserializer);
    }

    /**
     * @dataProvider getTestSetValidationGroupsExceptionsData
     * @param mixed $validationGroups
     */
    public function testSetValidationGroupsExceptions($validationGroups): void
    {
        $deserializerBuilder = $this->getDeserializerBuilder();
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Validation groups should be array of strings or callable');
        $deserializerBuilder->setValidationGroups($validationGroups);
    }

    /**
     * @dataProvider getTestSetValidationGroupsData
     * @param $settedValidationGroups
     * @param $gettedValidationGroups
     */
    public function testSetValidationGroups($settedValidationGroups, $gettedValidationGroups): void
    {
        $deserializerBuilder = $this->getDeserializerBuilder();
        $deserializerBuilder->setValidationGroups($settedValidationGroups);

        static::assertSame($gettedValidationGroups, $deserializerBuilder->getValidationGroups());
    }

    /**
     * @throws \ReflectionException
     */
    public function testGetSerializerContext(): void
    {
        $objectToPopulate = new \stdClass();
        $deserializerBuilder = $this->getDeserializerBuilder();
        $deserializerBuilder
            ->setDeserializationGroups(['deserialization_group'])
            ->setObjectToPopulate($objectToPopulate)
        ;
        $context = $this->invokePrivateMethod($deserializerBuilder, 'getSerializerContext');

        static::assertArrayHasKey('groups', $context);
        static::assertSame(['deserialization_group'], $context['groups']);
        static::assertSame(['deserialization_group'], $deserializerBuilder->getDeserializationGroups());

        static::assertArrayHasKey('object_to_populate', $context);
        static::assertSame($objectToPopulate, $context['object_to_populate']);
        static::assertSame($objectToPopulate, $deserializerBuilder->getObjectToPopulate());
    }

    /**
     * @throws \ReflectionException
     */
    public function testGetSerializerContextWillMergeSetContextAndOverwrittenValues(): void
    {
        $objectToPopulate = new \stdClass();
        $deserializerBuilder = $this->getDeserializerBuilder();
        $deserializerBuilder
            ->setDeserializerContext([
                'groups' => 'deserialization_group',
            ])
            ->setDeserializationGroups(['overwritten_group'])
            ->setObjectToPopulate($objectToPopulate)
        ;
        $context = $this->invokePrivateMethod($deserializerBuilder, 'getSerializerContext');

        static::assertArrayHasKey('groups', $context);
        static::assertSame(['overwritten_group'], $context['groups']);

        static::assertArrayHasKey('object_to_populate', $context);
        static::assertSame($objectToPopulate, $context['object_to_populate']);
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
     * @return array
     */
    public function getTestSetValidationGroupsData(): array
    {
        $callableFunction = function(){};
        $object = new \stdClass();
        $callable = [$object, 'foo'];

        return [
            [$callableFunction, $callableFunction],
            [$callable, $callable],
            [['validation_group'], ['validation_group']],
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
