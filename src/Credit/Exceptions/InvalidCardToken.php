<?php

namespace Wearesho\Bobra\Platon\Credit\Exceptions;

use Wearesho\Bobra\Payments\Credit;
use Wearesho\Bobra\Platon;

/**
 * Class InvalidCardToken
 * @package Wearesho\Bobra\Platon\Credit\Exceptions
 */
class InvalidCardToken extends Platon\Credit\Exception implements Credit\Exception\InvalidCardToken
{
    public function __construct(Credit\TransferInterface $transfer, int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($transfer, 'Invalid card', $code, $previous);
    }
}
