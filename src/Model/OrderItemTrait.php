<?php

declare(strict_types=1);

namespace Setono\SyliusGiftCardPlugin\Model;

use Sylius\Component\Order\Model\OrderItemInterface as BaseOrderItemInterface;

trait OrderItemTrait
{
    public function equals(BaseOrderItemInterface $item): bool
    {
        if ($this === $item) {
            return true;
        }

        if (false === parent::equals($item)) {
            return false;
        }

        return false === $this->getProduct()?->isGiftCard();
    }
}
