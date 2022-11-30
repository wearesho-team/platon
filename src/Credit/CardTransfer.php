<?php

namespace Wearesho\Bobra\Platon\Credit;

use Wearesho\Bobra\Payments\Credit;

class CardTransfer extends Credit\Transfer implements CreditToCardInterface, HasExpireDate
{
    use HasExpireDateTrait;

    public function __construct(
        int $id,
        int $amount,
        string $card,
        int $expireMonth,
        int $expireYear,
        string $description = null,
        string $currency = null
    ) {
        parent::__construct($id, $amount, $card, $description, $currency);

        $this
            ->setExpireMonth($expireMonth)
            ->setExpireYear($expireYear);
    }
}
