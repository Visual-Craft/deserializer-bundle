<?php

namespace VisualCraft\DeserializerBundle\Test\PHPUnit\Framework;

use PHPUnit\Framework\TestCase as FrameworkTestCase;

abstract class TestCase extends FrameworkTestCase
{
    /**
     * @param $object
     * @param string $methodName
     * @param array $parameters
     * @throws \ReflectionException
     * @return mixed
     */
    protected function invokePrivateMethod($object, string $methodName, array $parameters = [])
    {
        $reflection = new \ReflectionClass(\get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}
