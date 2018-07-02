<?php

namespace Wearesho\Bobra\Platon\Credit;

use Wearesho\Bobra\Payments\Credit;

/**
 * Trait CreditToCardTrait
 * @package Wearesho\Bobra\Platon\Credit
 */
trait CreditToCardTrait
{
    use Credit\TransferTrait;

    protected function setCardToken(string $cardToken): self
    {
        if (!preg_match('/\w{32}/', $cardToken)) {
            throw new \InvalidArgumentException("Invalid Card Token");
        }

        $this->cardToken = $cardToken;

        return $this;
    }
}
