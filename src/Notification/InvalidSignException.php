<?php

namespace Wearesho\Bobra\Platon\Notification;

use Throwable;

/**
 * Class InvalidSignException
 * @package Wearesho\Bobra\Platon\Notification
 */
class InvalidSignException extends \Exception
{
    public function __construct(int $code = 0, Throwable $previous = null)
    {
        parent::__construct("Invalid sign passed", $code, $previous);
    }
}
