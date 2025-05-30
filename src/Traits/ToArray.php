<?php

declare(strict_types=1);

namespace DWenzel\ReporterApi\Traits;

/**
 * Trait ToArrayTrait
 */
trait ToArray
{
    /**
     * Return the object as array
     *
     * @param int $depth maximum tree depth
     * @param array $mapping An array with keys for each model
     * which should be mapped.
     * @return array
     */
    public function toArray(int $depth = 100, ?array $mapping = null): array
    {
        if ($depth < 1) {
            return [];
        }
        $depth = $depth - 1;
        $className = static::class;
        $properties = $this->getSerializableProperties($className);
        $result = [];
        foreach ($properties as $propertyName => $propertyValue) {
            $maxDepth = $depth;

            $hasMapping = false;
            if ((bool)$mapping) {
                $hasMapping = isset($mapping[$className]);
            }
            if ($hasMapping && array_key_exists($propertyName, $mapping[$className])) {
                if (isset($mapping[$className][$propertyName]['mapTo'])) {
                    $propertyName = $mapping[$className][$propertyName]['mapTo'];
                } elseif (isset($mapping[$className][$propertyName]['exclude'])) {
                    continue;
                }

                if (isset($mapping[$className][$propertyName]['maxDepth'])) {
                    $maxDepth = $mapping[$className][$propertyName]['maxDepth'];
                }
            }
            $result[$propertyName] = $this->valueToArray($propertyValue, $maxDepth, $mapping);
        }

        return $result;
    }

    /**
     * Convert a property value to an array
     *
     * @param mixed $value
     * @param int $treeDepth
     * @param null $mapping
     * @return mixed
     * @internal param mixed $value Value of the property
     * @internal param int $treeDepth maximum tree depth, default 100
     * @var array $mapping An array with mapping rules
     */
    protected function valueToArray(mixed $value, int $treeDepth = 100, ?array $mapping = null): mixed
    {
        if ($value instanceof \JsonSerializable) {
            return $value->jsonSerialize();
        }
        if (is_iterable($value)) {
            $result = [];
            foreach ($value as $key => $item) {
                $result[$key] = $this->valueToArray($item, $treeDepth - 1, $mapping);
            }
            return $result;
        }
        if (is_object($value) && method_exists($value, 'toArray')) {
            return $value->toArray($treeDepth, $mapping);
        }

        return $value;
    }

    /**
     * @return array
     */
    protected function getSerializableProperties(string $className): array
    {
        $serializableProperties = [];
        try {
            $reflection = new \ReflectionClass($className);
            if ($reflection->hasConstant('SERIALIZABLE_PROPERTIES')) {
                foreach ($className::SERIALIZABLE_PROPERTIES as $propertyName) {
                    $accessorMethod = 'get' . ucfirst($propertyName);
                    if ($reflection->hasMethod($accessorMethod)) {
                        $serializableProperties[$propertyName] = $this->{$accessorMethod}();
                    }
                }
            }
        } catch (\ReflectionException $e) {
            return [];
        }

        return $serializableProperties;
    }
}
