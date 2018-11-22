<?php

namespace Wearesho\Bobra\Platon\Info;

use Throwable;

/**
 * Class InvalidResponseException
 * @package Wearesho\Bobra\Platon\Info
 */
class InvalidResponseException extends \RuntimeException
{
    /** @var array */
    protected $body;

    public function __construct(string $message, int $code, array $body, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->body = $body;
    }

    public function getBody(): array
    {
        return $this->body;
    }

    public function __toString(): string
    {
        return parent::__toString() . PHP_EOL . "Body: {$this->body}";
    }
}
