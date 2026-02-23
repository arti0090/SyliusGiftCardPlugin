<?php

declare(strict_types=1);

namespace Setono\SyliusGiftCardPlugin\Tests\Behat\Context\Api;

enum Resources: string
{
    case GIFT_CARDS = 'gift-cards';
    case GIFT_CARDS_BALANCE = 'gift-cards/balance';
    case GIFT_CARD_CONFIGURATIONS = 'gift-card-configurations';
}
