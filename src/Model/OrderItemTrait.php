<?php

declare(strict_types=1);

namespace Setono\SyliusGiftCardPlugin\Model;

use Sylius\Component\Order\Model\OrderItemInterface as BaseOrderItemInterface;

trait OrderItemTrait
{
    public function equals(BaseOrderItemInterface $orderItem): bool
    {
        if ($this === $orderItem) {
            return true;
        }

        if (false === parent::equals($orderItem)) {
            return false;
        }

        return false === $this->getProduct()?->isGiftCard();
    }
}
