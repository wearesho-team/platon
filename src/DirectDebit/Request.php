<?php

declare(strict_types=1);

namespace Wearesho\Bobra\Platon\DirectDebit;

readonly class Request
{
    public function __construct(
        public string $orderId,
        public float $amount,
        public string $description,
        public string $cardToken,
        public string $termUrl,
        public string $phone,
        public ?string $email = null,
        public array $ext = []
    ) {
    }

    public function hash(string $pass): string
    {
        return md5(
            strtoupper(
                strrev($this->email ?? '')
                . $pass
                . strrev($this->cardToken)
            )
        );
    }
}
