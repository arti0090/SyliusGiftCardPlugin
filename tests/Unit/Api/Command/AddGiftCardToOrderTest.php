<?php

declare(strict_types=1);

namespace Setono\SyliusGiftCardPlugin\Tests\Unit\Api\Command;

use PHPUnit\Framework\TestCase;
use Setono\SyliusGiftCardPlugin\Api\Command\AddGiftCardToOrder;

class AddGiftCardToOrderTest extends TestCase
{
    public function test_it_is_initializable(): void
    {
        $command = new AddGiftCardToOrder('order_code');

        $this->assertInstanceOf(AddGiftCardToOrder::class, $command);
    }

    public function test_it_has_nullable_gift_card_code(): void
    {
        $command = new AddGiftCardToOrder('order_token_vaue');

        $this->assertNull($command->giftCardCode);
    }
}
