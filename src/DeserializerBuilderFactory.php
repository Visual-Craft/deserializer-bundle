<?php

namespace VisualCraft\DeserializerBundle;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DeserializerBuilderFactory
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @param ValidatorInterface $validator
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * @param string $class
     * @return DeserializerBuilder
     */
    public function create(string $class): DeserializerBuilder
    {
        return new DeserializerBuilder($class, $this->serializer, $this->validator);
    }
}
