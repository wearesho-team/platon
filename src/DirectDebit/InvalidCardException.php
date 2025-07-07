<?php

declare(strict_types=1);

namespace Wearesho\Bobra\Platon\DirectDebit;

class InvalidCardException extends Exception
{
    public static function getMessages(): array
    {
        return [
            'Invalid card_exp_month, card_exp_year',
            'Invalid card_exp_month',
            'Initial transaction too old',
        ];
    }
}
