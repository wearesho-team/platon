<?php

namespace Wearesho\Bobra\Platon\Credit;

/**
 * Class CreditToCard
 * @package Wearesho\Bobra\Platon\Credit
 */
class CreditToCard implements CreditToCardInterface
{
    use CreditToCardTrait;

    public function __construct(
        int $id,
        int $amount,
        string $cardToken,
        string $description = null,
        string $currency = null
    ) {
        $this->id = $id;
        $this->amount = $amount;
        $this->description = $description;
        $this->currency = $currency;
        $this->setCardToken($cardToken);
    }
}
