<?php

declare(strict_types=1);

namespace Setono\SyliusGiftCardPlugin\Api\StateProcessor\GiftCard;

use ApiPlatform\Metadata\DeleteOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Setono\SyliusGiftCardPlugin\Model\GiftCardInterface;
use Webmozart\Assert\Assert;

/** @implements ProcessorInterface<GiftCardInterface, mixed> */
final readonly class PersistProcessor implements ProcessorInterface
{
    public function __construct(private ProcessorInterface $persistProcessor)
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        Assert::isInstanceOf($data, GiftCardInterface::class);
        Assert::notInstanceOf($operation, DeleteOperationInterface::class);

        $data->setOrigin(GiftCardInterface::ORIGIN_API);

        return $this->persistProcessor->process($data, $operation, $uriVariables, $context);
    }
}
