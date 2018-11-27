<?php

namespace VisualCraft\ApiDeserializerBundle\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationErrorException extends \RuntimeException
{
    /**
     * @var ConstraintViolationListInterface
     */
    private $violations;

    public function __construct(ConstraintViolationListInterface $violations, $message = '', $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->violations = $violations;
    }

    /**
     * @return ConstraintViolationListInterface
     */
    public function getViolations(): ConstraintViolationListInterface
    {
        return $this->violations;
    }
}
