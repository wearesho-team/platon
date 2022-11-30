<?php

namespace Wearesho\Bobra\Platon\Credit;

use Wearesho\Bobra\Payments\Credit;

class Response extends \ArrayObject implements Credit\Response
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
        return $this->getResult() === Response\Result::SUCCESS;
    }

    public function isWaiting(): bool
    {
        return $this->offsetExists('status') && $this['status'] === Response\Status::WAITING;
    }
}
