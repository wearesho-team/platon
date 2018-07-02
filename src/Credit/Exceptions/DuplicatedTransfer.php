<?php

namespace Wearesho\Bobra\Platon\Credit\Exceptions;

use Wearesho\Bobra\Payments\Credit;
use Wearesho\Bobra\Platon;

/**
 * Class DuplicatedTransfer
 * @package Wearesho\Bobra\Platon\Credit\Exceptions
 */
class DuplicatedTransfer extends Platon\Credit\Exception implements Credit\Exception\DuplicatedTransfer
{
    public function __construct(Credit\TransferInterface $transfer, int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($transfer, 'Duplicate request', $code, $previous);
    }
}
