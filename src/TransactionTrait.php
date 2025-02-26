<?php

namespace Wearesho\Bobra\Platon;

/**
 * Trait TransactionTrait
 * @package Wearesho\Bobra\Platon
 */
trait TransactionTrait
{
    protected ?string $formId = null;

    protected ?string $cardToken = null;

    public function getFormId(): ?string
    {
        return $this->formId;
    }

    public function getCardToken(): ?string
    {
        return $this->cardToken;
    }

    public function jsonSerialize(): array
    {
        $data = [];
        if (!is_null($this->formId)) {
            $data['formId'] = $this->formId;
        }
        if (!is_null($this->cardToken)) {
            $data['cardToken'] = $this->cardToken;
        }
        return $data;
    }
}
