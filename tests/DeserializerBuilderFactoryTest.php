<?php

namespace VisualCraft\DeserializerBundle\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use VisualCraft\DeserializerBundle\DeserializerBuilder;
use VisualCraft\DeserializerBundle\DeserializerBuilderFactory;

class DeserializerBuilderFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $serializer = $this->createMock(SerializerInterface::class);
        $validator = $this->createMock(ValidatorInterface::class);
        $deserialiazerBuilderFactory = new DeserializerBuilderFactory($serializer, $validator);
        $deserialiazerBuilder = $deserialiazerBuilderFactory->create(\stdClass::class);

        static::assertInstanceOf(DeserializerBuilder::class, $deserialiazerBuilder);
        static::assertSame($deserialiazerBuilder->getClass(), \stdClass::class);
        static::assertSame($deserialiazerBuilder->getSerializer(), $serializer);
        static::assertSame($deserialiazerBuilder->getValidator(), $validator);
    }
}
