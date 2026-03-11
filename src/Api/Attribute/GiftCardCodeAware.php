<?php

declare(strict_types=1);

namespace Setono\SyliusGiftCardPlugin\Api\Attribute;

#[\Attribute(\Attribute::TARGET_CLASS)]
class GiftCardCodeAware
{
    public const DEFAULT_ARGUMENT_NAME = 'giftCardCode';

    public function __construct(public string $constructorArgumentName = self::DEFAULT_ARGUMENT_NAME)
    {
    }
}
