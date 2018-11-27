<?php

namespace VisualCraft\ApiDeserializerBundle;

use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use VisualCraft\ApiDeserializerBundle\Exception\InvalidRequestBodyFormatException;
use VisualCraft\ApiDeserializerBundle\Exception\ValidationErrorException;

class ApiDeserializer
{
    /**
     * @var string
     */
    private $class;

    /**
     * @var callable|string[]
     */
    private $validationGroups;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var array
     */
    private $serializerContext;

    /**
     * @param string $class
     * @param ValidatorInterface $validator
     * @param SerializerInterface $serializer
     * @param array $serializerContext
     * @param callable|string[] $validationGroups
     */
    public function __construct(
        string $class,
        ValidatorInterface $validator,
        SerializerInterface $serializer,
        array $serializerContext,
        $validationGroups
    ) {
        $this->class = $class;
        $this->validator = $validator;
        $this->serializer = $serializer;
        $this->serializerContext = $serializerContext;
        $this->validationGroups = $validationGroups;
    }

    /**
     * @param mixed $data
     * @param string $format
     * @return object|object[]
     */
    public function deserialize($data, string $format = 'json')
    {
        try {
            $deserializeObject = $this->serializer->deserialize(
                $data,
                $this->class,
                $format,
                $this->serializerContext
            );
        } catch (UnexpectedValueException $e) {
            throw new InvalidRequestBodyFormatException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }

        $this->validOrThrow($deserializeObject);

        return $deserializeObject;
    }

    /**
     * @param object $object
     */
    private function validOrThrow($object): void
    {
        $validationGroups = $this->validationGroups;

        if (is_callable($this->validationGroups)) {
            $validationGroups = $validationGroups($object);
        }

        $violationList = $this->validator->validate($object, null, $validationGroups);

        if (count($violationList) !== 0) {
            throw new ValidationErrorException($violationList);
        }
    }
}
