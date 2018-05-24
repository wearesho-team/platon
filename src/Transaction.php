<?php

namespace Wearesho\Bobra\Platon;

use Wearesho\Bobra\Payments;

/**
 * Class Transaction
 * @package Wearesho\Bobra\Platon
 */
class Transaction extends Payments\Transaction implements TransactionInterface
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
        string $formId = null
    ) {
        parent::__construct($service, $amount, $type, $description, $info, $currency);
        $this->formId = $formId;
    }

    public function jsonSerialize()
    {
        return array_merge(parent::jsonSerialize(), $this->platonJsonSerialize());
    }
}