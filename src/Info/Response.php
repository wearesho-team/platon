<?php

declare(strict_types=1);

namespace Wearesho\Bobra\Platon\Info;

class Response implements \JsonSerializable
{
    protected string $id;

    protected int $account;

    protected int $type;

    protected \DateTimeInterface $lastOperation;

    protected float $outcome;

    protected float $balance;

    protected array $raw;

    public function __construct(
        string $id,
        int $type,
        int $account,
        \DateTimeInterface $lastOperation,
        float $outcome,
        float $balance,
        array $raw = []
    ) {
        $this->id = $id;
        $this->type = $type;
        $this->account = $account;
        $this->lastOperation = $lastOperation;
        $this->outcome = $outcome;
        $this->balance = $balance;
        $this->raw = $raw;
    }

    /**
     * Ключ
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Транзитный счет
     */
    public function getAccount(): int
    {
        return $this->account;
    }

    /**
     * Дата\время последней операции
     */
    public function getLastOperation(): \DateTimeInterface
    {
        return $this->lastOperation;
    }

    /**
     * Выплачено
     */
    public function getOutcome(): float
    {
        return $this->outcome;
    }

    /**
     * Баланс
     */
    public function getBalance(): float
    {
        return $this->balance;
    }

    /**
     * 1 - Privat
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * Get raw array response from Platon
     * @return array
     */
    public function getRaw(): array
    {
        return $this->raw;
    }

    public function jsonSerialize(): array
    {
        return [
                'lastOperation' => $this->lastOperation->format('Y-m-d H:i:s'),
            ] + array_diff_key(get_object_vars($this), ['raw' => null]);
    }

    public function __toString(): string
    {
        $result = "";
        switch ($this->type) {
            case '1':
                $result .= "************PRIVAT************\n";
                break;
            default:
                $result .= "************DIAMANT************\n";
        }
        $result .= "Ключ = {$this->id}\n";
        $result .= "Остаток = {$this->balance}\n";
        $result .= "Транзитный счет = {$this->account}\n";
        $result .= "Дата/время последней операции = {$this->lastOperation->format('Y-m-d H:i:s')}\n";
        $result .= "Выплачено = {$this->outcome}";

        return $result;
    }
}
