<?php

namespace Wearesho\Bobra\Platon\Credit;

/**
 * Class Response
 * @package Wearesho\Bobra\Platon\Credit
 */
class Response extends \ArrayObject
{
    public function __construct(array $input = [], int $flags = 0, string $iterator_class = "ArrayIterator")
    {
        if (!array_key_exists('result', $input)) {
            throw new \InvalidArgumentException('Response Array have to contain result key');
        }

        parent::__construct($input, $flags, $iterator_class);
    }

    public function getResult(): string
    {
        return $this['result'];
    }

    public function isSuccessful(): bool
    {
        return $this->getResult() === 'SUCCESS';
    }
}
