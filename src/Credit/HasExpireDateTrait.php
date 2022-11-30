<?php

namespace Wearesho\Bobra\Platon\Credit;

use Carbon\Carbon;

trait HasExpireDateTrait
{
    protected int $expireMonth;

    protected int $expireYear;

    public function getExpireMonth(): int
    {
        return $this->expireMonth;
    }

    protected function setExpireMonth(int $expireMonth): self
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

    protected function setExpireYear(int $expireYear): self
    {
        if (
            $expireYear < (int)Carbon::now()->format('y')
            || $expireYear > (int)Carbon::now()->addYears(10)->format('y')
        ) {
            throw new \InvalidArgumentException("Invalid expire year {$expireYear} passed");
        }

        $this->expireYear = $expireYear;

        return $this;
    }
}
