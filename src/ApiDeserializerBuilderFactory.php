<?php

namespace VisualCraft\ApiDeserializerBundle;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApiDeserializerBuilderFactory
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
     * @return ApiDeserializerBuilder
     */
    public function getInstance(string $class): ApiDeserializerBuilder
    {
        return new ApiDeserializerBuilder($class, $this->serializer, $this->validator);
    }
}
