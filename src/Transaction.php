<?php

namespace Wearesho\Bobra\Platon;

use Wearesho\Bobra\Payments;

class Transaction extends Payments\Transaction implements TransactionInterface, Transaction\CardToken
{
    use TransactionTrait {
        jsonSerialize as private platonJsonSerialize;
    }

    public function __construct(
        int $service,
        float $amount,
        string $type,
        string $description,
        array $info = [],
        string $currency = 'UAH',
        string $formId = null,
        string $cardToken = null
    ) {
        parent::__construct($service, $amount, $type, $description, $info, $currency);
        $this->formId = $formId;
        $this->cardToken = $cardToken;
    }

    public function jsonSerialize(): array
    {
        return array_merge(parent::jsonSerialize(), $this->platonJsonSerialize());
    }
}
