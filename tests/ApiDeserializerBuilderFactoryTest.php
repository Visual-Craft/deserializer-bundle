<?php

namespace VisualCraft\ApiDeserializer\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use VisualCraft\ApiDeserializerBundle\ApiDeserializerBuilderFactory;

class ApiDeserializerBuilderFactoryTest extends TestCase
{
    public function testGetInstance(): void
    {
        $serializer = $this->createMock(SerializerInterface::class);
        $validator = $this->createMock(ValidatorInterface::class);
        $apiDeserialiazerBuilderFactory = new ApiDeserializerBuilderFactory($serializer, $validator);
        $instance = $apiDeserialiazerBuilderFactory->getInstance(\stdClass::class);

        static::assertSame($instance->getClass(), \stdClass::class);
        static::assertSame($instance->getSerializer(), $serializer);
        static::assertSame($instance->getValidator(), $validator);
    }
}
