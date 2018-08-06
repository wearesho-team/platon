<?php

namespace Wearesho\Bobra\Platon\Credit;

use Carbon\Carbon;
use Wearesho\Bobra\Payments\Credit;

/**
 * Class CardTransfer
 * @package Wearesho\Bobra\Platon\Credit
 */
class CardTransfer extends Credit\Transfer implements CreditToCardInterface, HasExpireDate
{
    protected $expireMonth;

    protected $expireYear;

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

    public function getExpireMonth(): int
    {
        return $this->expireMonth;
    }

    protected function setExpireMonth(int $expireMonth): CardTransfer
    {
        if ($expireMonth < 1 || $expireMonth > 12) {
            throw new \InvalidArgumentException("Invalid expire month {$expireMonth} passed");
        }

        $this->expireMonth = $expireMonth;

        return $this;
    }

    public function getExpireYear(): int
    {
        return $this->expireYear;
    }

    protected function setExpireYear(int $expireYear): CardTransfer
    {
        if ($expireYear < (int)Carbon::now()->format('y')
            || $expireYear > (int)Carbon::now()->addYears(10)->format('y')
        ) {
            throw new \InvalidArgumentException("Invalid expire year {$expireYear} passed");
        }

        $this->expireYear = $expireYear;

        return $this;
    }
}
