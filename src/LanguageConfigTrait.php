<?php

namespace Wearesho\Bobra\Platon;

/**
 * Trait LanguageConfigTrait
 * @package Wearesho\Bobra\Platon
 */
trait LanguageConfigTrait
{
    /** @var string */
    protected $language = ConfigInterface::LANGUAGE_UA;

    /**
     * @inheritdoc
     * @see ConfigInterface::getLanguage()
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    public function setLanguage(string $language): self
    {
        if (
            $language !== ConfigInterface::LANGUAGE_UA
            && $language !== ConfigInterface::LANGUAGE_RU
        ) {
            throw new \InvalidArgumentException("Invalid language");
        }

        $this->language = $language;
        return $this;
    }
}
