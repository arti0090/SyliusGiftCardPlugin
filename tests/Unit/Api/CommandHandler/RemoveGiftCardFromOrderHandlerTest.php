<?php

declare(strict_types=1);

namespace Setono\SyliusGiftCardPlugin\Tests\Unit\Api\CommandHandler;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Setono\SyliusGiftCardPlugin\Api\Command\RemoveGiftCardFromOrder;
use Setono\SyliusGiftCardPlugin\Api\CommandHandler\RemoveGiftCardFromOrderHandler;
use Setono\SyliusGiftCardPlugin\Applicator\GiftCardApplicatorInterface;
use Setono\SyliusGiftCardPlugin\Model\GiftCard;
use Setono\SyliusGiftCardPlugin\Repository\GiftCardRepositoryInterface;
use Setono\SyliusGiftCardPlugin\Repository\OrderRepositoryInterface;
use Tests\Setono\SyliusGiftCardPlugin\Entity\Order;

final class RemoveGiftCardFromOrderHandlerTest extends TestCase
{
    use ProphecyTrait;

    public function test_it_removes_gift_card_from_order(): void
    {
        $giftCard = new GiftCard();
        $order = new Order();

        $command = new RemoveGiftCardFromOrder('order_token_value', 'gc_code');

        $giftCardRepository = $this->prophesize(GiftCardRepositoryInterface::class);
        $orderRepository = $this->prophesize(OrderRepositoryInterface::class);
        $giftCardApplicator = $this->prophesize(GiftCardApplicatorInterface::class);

        $giftCardRepository->findOneByCode('gc_code')->willReturn($giftCard);
        $orderRepository->findOneBy(['tokenValue' => 'order_token_value'])->willReturn($order);
        $giftCardApplicator->remove($order, $giftCard)->shouldBeCalled();

        $removeGiftCardFromOrderHandler = new RemoveGiftCardFromOrderHandler(
            $giftCardRepository->reveal(),
            $orderRepository->reveal(),
            $giftCardApplicator->reveal(),
        );
        $removeGiftCardFromOrderHandler($command);
    }

    public function test_it_throws_error_if_gift_card_code_is_null(): void
    {
        $command = new RemoveGiftCardFromOrder('order_token_value', 'gc_code');

        $giftCardRepository = $this->prophesize(GiftCardRepositoryInterface::class);
        $orderRepository = $this->prophesize(OrderRepositoryInterface::class);
        $giftCardApplicator = $this->prophesize(GiftCardApplicatorInterface::class);

        $this->expectException(InvalidArgumentException::class);

        $removeGiftCardFromOrderHandler = new RemoveGiftCardFromOrderHandler(
            $giftCardRepository->reveal(),
            $orderRepository->reveal(),
            $giftCardApplicator->reveal(),
        );
        $removeGiftCardFromOrderHandler($command);
    }

    public function test_it_throws_error_if_gift_card_not_found(): void
    {
        $command = new RemoveGiftCardFromOrder('order_token_value', 'gc_code');

        $giftCardRepository = $this->prophesize(GiftCardRepositoryInterface::class);
        $orderRepository = $this->prophesize(OrderRepositoryInterface::class);
        $giftCardApplicator = $this->prophesize(GiftCardApplicatorInterface::class);

        $this->expectException(InvalidArgumentException::class);

        $removeGiftCardFromOrderHandler = new RemoveGiftCardFromOrderHandler(
            $giftCardRepository->reveal(),
            $orderRepository->reveal(),
            $giftCardApplicator->reveal(),
        );
        $removeGiftCardFromOrderHandler($command);
    }

    public function test_it_throws_exception_if_order_not_found(): void
    {
        $giftCard = new GiftCard();
        $command = new RemoveGiftCardFromOrder('order_token_value', 'gc_code');

        $giftCardRepository = $this->prophesize(GiftCardRepositoryInterface::class);
        $orderRepository = $this->prophesize(OrderRepositoryInterface::class);
        $giftCardApplicator = $this->prophesize(GiftCardApplicatorInterface::class);

        $giftCardRepository->findOneByCode('gc_code')->willReturn($giftCard);

        $this->expectException(InvalidArgumentException::class);

        $removeGiftCardFromOrderHandler = new RemoveGiftCardFromOrderHandler(
            $giftCardRepository->reveal(),
            $orderRepository->reveal(),
            $giftCardApplicator->reveal(),
        );
        $removeGiftCardFromOrderHandler($command);
    }
}
