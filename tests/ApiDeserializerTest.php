<?php

namespace VisualCraft\ApiDeserializerBundle\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use VisualCraft\ApiDeserializerBundle\ApiDeserializer;
use VisualCraft\ApiDeserializerBundle\Exception\InvalidRequestBodyFormatException;
use VisualCraft\ApiDeserializerBundle\Exception\ValidationErrorException;

class ApiDeserializerTest extends TestCase
{
    public function testDeserialize(): void
    {
        $validator = $this->getAlwaysValidValidator();
        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);

        $apiDeserializer = new ApiDeserializer(DummyDataClass::class, $validator, $serializer, [], []);
        /** @var DummyDataClass $deserialized */
        $deserialized = $apiDeserializer->deserialize(json_encode([
            'key' => 'value',
        ]));

        static::assertInstanceOf(DummyDataClass::class, $deserialized);
        static::assertObjectHasAttribute('key', $deserialized);
        static::assertSame('value', $deserialized->getKey());
    }

    public function testDeserializeThrowInvalidRequestBodyFormatException(): void
    {
        $validator = $this->getAlwaysValidValidator();
        $serializer = $this->createMock(SerializerInterface::class);
        $serializer
            ->method('deserialize')
            ->willThrowException(new UnexpectedValueException())
        ;
        $apiDeserializer = new ApiDeserializer(\stdClass::class, $validator, $serializer, [], []);

        $this->expectException(InvalidRequestBodyFormatException::class);
        $apiDeserializer->deserialize(json_encode([
            'key' => 'value',
        ]));
    }

    public function testValidatorException(): void
    {
        $validator = $this->createMock(ValidatorInterface::class);
        $validator
            ->method('validate')
            ->willReturn(new ConstraintViolationList([new ConstraintViolation(null, null, [], '', '', '')]))
        ;
        $serializer = $this->createMock(SerializerInterface::class);
        $this->expectException(ValidationErrorException::class);
        $apiDeserializer = new ApiDeserializer(\stdClass::class, $validator, $serializer, [], []);
        $apiDeserializer->deserialize(json_encode([
            'key' => 'value',
        ]));
    }

    /**
     * @return ValidatorInterface
     */
    private function getAlwaysValidValidator(): ValidatorInterface
    {
        $validator = $this->createMock(ValidatorInterface::class);
        $validator
            ->method('validate')
            ->willReturn(new ConstraintViolationList())
        ;

        return $validator;
    }
}
