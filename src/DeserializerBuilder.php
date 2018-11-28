<?php

namespace VisualCraft\DeserializerBundle;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DeserializerBuilder
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
     * @var object
     */
    private $objectToPopulate;

    /**
     * @var string[]
     */
    private $deserializationGroups;

    /**
     * @var array
     */
    private $deserializerContext;

    /**
     * @param string $class
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     */
    public function __construct(
        string $class,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ) {
        $this->class = $class;
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->deserializationGroups = ['Default'];
        $this->validationGroups = [];
        $this->deserializerContext = [];
    }

    /**
     * @return Deserializer
     */
    public function getDeserializer(): Deserializer
    {
        return new Deserializer(
            $this->class,
            $this->validator,
            $this->serializer,
            $this->getSerializerContext(),
            $this->validationGroups
        );
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @return ValidatorInterface
     */
    public function getValidator(): ValidatorInterface
    {
        return $this->validator;
    }

    /**
     * @return SerializerInterface
     */
    public function getSerializer(): SerializerInterface
    {
        return $this->serializer;
    }

    /**
     * @return callable|string[]
     */
    public function getValidationGroups()
    {
        return $this->validationGroups;
    }

    /**
     * @param callable|string[] $value
     * @return $this
     */
    public function setValidationGroups($value)
    {
        if (!(is_callable($value) || is_array($value))) {
            throw new \InvalidArgumentException('Validation groups should be array of strings or callable');
        }

        $this->validationGroups = $value;

        return $this;
    }

    /**
     * @return object
     */
    public function getObjectToPopulate()
    {
        return $this->objectToPopulate;
    }

    /**
     * @param object $value
     * @return $this
     */
    public function setObjectToPopulate($value)
    {
        $this->objectToPopulate = $value;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getDeserializationGroups(): array
    {
        return $this->deserializationGroups;
    }

    /**
     * @param string[] $value
     * @return $this
     */
    public function setDeserializationGroups(array $value)
    {
        $this->deserializationGroups = $value;

        return $this;
    }

    /**
     * @param array $value
     * @return $this
     */
    public function setDeserializerContext(array $value)
    {
        $this->deserializerContext = $value;

        return $this;
    }

    /**
     * @return array
     */
    private function getSerializerContext(): array
    {
        $context = [];

        if ($this->objectToPopulate) {
            $context['object_to_populate'] = $this->objectToPopulate;
        }

        if ($this->deserializationGroups) {
            $context['groups'] = $this->deserializationGroups;
        }

        return array_replace($this->deserializerContext, $context);
    }
}
