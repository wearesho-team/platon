<?php

declare(strict_types=1);

namespace Wearesho\Bobra\Platon\Notification;

use Throwable;

class InvalidSignException extends \Exception
{
    public function __construct(int $code = 0, Throwable $previous = null)
    {
        parent::__construct("Invalid sign passed", $code, $previous);
    }
}
