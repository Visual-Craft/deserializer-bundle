<?php

namespace VisualCraft\DeserializerBundle\Tests;

class DummyDataClass
{
    /**
     * @var string
     */
    private $key;

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param mixed $value
     * @return $this
     */
    public function setKey($value): self
    {
        $this->key = $value;

        return $this;
    }
}
