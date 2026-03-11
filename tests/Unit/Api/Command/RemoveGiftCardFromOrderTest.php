<?php

declare(strict_types=1);

namespace Setono\SyliusGiftCardPlugin\Tests\Unit\Api\Command;

use PHPUnit\Framework\TestCase;
use Setono\SyliusGiftCardPlugin\Api\Command\RemoveGiftCardFromOrder;

class RemoveGiftCardFromOrderTest extends TestCase
{
    public function test_it_is_initializable(): void
    {
        $command = new RemoveGiftCardFromOrder('order_code');

        $this->assertInstanceOf(RemoveGiftCardFromOrder::class, $command);
    }

    public function test_it_has_nullable_gift_card_code(): void
    {
        $command = new RemoveGiftCardFromOrder('order_token_vaue');

        $this->assertNull($command->giftCardCode);
    }
}
