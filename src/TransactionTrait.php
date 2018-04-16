<?php

namespace Wearesho\Bobra\Platon;

/**
 * Trait TransactionTrait
 * @package Wearesho\Bobra\Platon
 */
trait TransactionTrait
{
    /** @var string|null */
    protected $formId = null;

    public function getFormId(): ?string
    {
        return $this->formId;
    }

    public function jsonSerialize()
    {
        return [
            'formId' => $this->formId,
        ];
    }
}
