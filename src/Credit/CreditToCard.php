<?php

namespace Wearesho\Bobra\Platon\Credit;

use Wearesho\Bobra\Payments\Credit;

/**
 * Class CreditToCard
 * @package Wearesho\Bobra\Platon\Credit
 */
class CreditToCard extends Credit\Transfer implements CreditToCardInterface
{
    use CreditToCardTrait;

    public function __construct(
        int $id,
        int $amount,
        string $cardToken,
        string $description = null,
        string $currency = null
    ) {
        parent::__construct($id, $amount, $cardToken, $description, $currency);
        $this->setCardToken($cardToken);
    }
}
