<?php

declare(strict_types=1);

namespace Wearesho\Bobra\Platon\Credit;

use Wearesho\Bobra\Payments\Credit;

class Exception extends Credit\Exception
{
    protected Response $response;

    public function __construct(
        Credit\TransferInterface $transfer,
        Response $response,
        string $message,
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($transfer, $message, $code, $previous);
        $this->response = $response;
    }

    public function getResponse(): Response
    {
        return $this->response;
    }
}
