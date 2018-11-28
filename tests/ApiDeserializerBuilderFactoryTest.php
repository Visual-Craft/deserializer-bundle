<?php

namespace VisualCraft\ApiDeserializerBundle\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use VisualCraft\ApiDeserializerBundle\ApiDeserializerBuilder;
use VisualCraft\ApiDeserializerBundle\ApiDeserializerBuilderFactory;

class ApiDeserializerBuilderFactoryTest extends TestCase
{
    public function testGetInstance(): void
    {
        $serializer = $this->createMock(SerializerInterface::class);
        $validator = $this->createMock(ValidatorInterface::class);
        $apiDeserialiazerBuilderFactory = new ApiDeserializerBuilderFactory($serializer, $validator);
        $apiDeserialiazerBuilder = $apiDeserialiazerBuilderFactory->getInstance(\stdClass::class);

        static::assertInstanceOf(ApiDeserializerBuilder::class, $apiDeserialiazerBuilder);
        static::assertSame($apiDeserialiazerBuilder->getClass(), \stdClass::class);
        static::assertSame($apiDeserialiazerBuilder->getSerializer(), $serializer);
        static::assertSame($apiDeserialiazerBuilder->getValidator(), $validator);
    }
}
