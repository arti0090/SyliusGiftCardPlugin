<?php

declare(strict_types=1);

namespace Setono\SyliusGiftCardPlugin\Tests\Unit\Api\StateProcessor\GiftCard;

use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Setono\SyliusGiftCardPlugin\Api\StateProcessor\GiftCard\PersistProcessor;
use Setono\SyliusGiftCardPlugin\Model\GiftCard;
use Setono\SyliusGiftCardPlugin\Model\GiftCardInterface;

final class PersistProcessorTest extends TestCase
{
    use ProphecyTrait;

    public function test_it_throws_exception_if_data_is_not_gift_card(): void
    {
        $innerProcessor = $this->prophesize(ProcessorInterface::class);
        $processor = new PersistProcessor($innerProcessor->reveal());

        $operation = $this->prophesize(Operation::class);

        $this->expectException(\InvalidArgumentException::class);

        $processor->process(new \stdClass(), $operation->reveal());
    }

    public function test_it_throws_exception_if_operation_is_delete(): void
    {
        $innerProcessor = $this->prophesize(ProcessorInterface::class);
        $processor = new PersistProcessor($innerProcessor->reveal());

        $operation = new Delete();

        $giftCard = new GiftCard();

        $this->expectException(\InvalidArgumentException::class);

        $processor->process($giftCard, $operation);
    }

    public function test_it_sets_origin_and_calls_inner_processor(): void
    {
        $innerProcessor = $this->prophesize(ProcessorInterface::class);
        $processor = new PersistProcessor($innerProcessor->reveal());

        $operation = $this->prophesize(Operation::class);

        $giftCard = new GiftCard();

        $innerProcessor
            ->process($giftCard, $operation, [], [])
            ->willReturn($giftCard)
            ->shouldBeCalled();

        $result = $processor->process($giftCard, $operation->reveal());

        $this->assertSame(GiftCardInterface::ORIGIN_API, $giftCard->getOrigin());
        $this->assertSame($giftCard, $result);
    }
}
