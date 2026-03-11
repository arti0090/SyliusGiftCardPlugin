<?php

declare(strict_types=1);

namespace Setono\SyliusGiftCardPlugin\Api\Command;

use Setono\SyliusGiftCardPlugin\Api\Attribute\GiftCardCodeAware;
use Sylius\Bundle\ApiBundle\Attribute\OrderTokenValueAware;

#[OrderTokenValueAware]
#[GiftCardCodeAware]
class RemoveGiftCardFromOrder
{
    public function __construct(
        public string $orderTokenValue,
        public ?string $giftCardCode = null,
    ) {
    }
}
