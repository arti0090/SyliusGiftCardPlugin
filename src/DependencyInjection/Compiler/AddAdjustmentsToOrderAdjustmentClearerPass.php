<?php

declare(strict_types=1);

namespace Setono\SyliusGiftCardPlugin\DependencyInjection\Compiler;

use Setono\SyliusGiftCardPlugin\Model\AdjustmentInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Webmozart\Assert\Assert;

final class AddAdjustmentsToOrderAdjustmentClearerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        /** @var array $adjustmentsToRemove */
        $adjustmentsToRemove = $container->getParameter('sylius.order_processing.adjustment_clearing_types');
        Assert::isArray($adjustmentsToRemove);

        $adjustmentsToRemove[] = AdjustmentInterface::ORDER_GIFT_CARD_ADJUSTMENT;

        $container->setParameter('sylius.order_processing.adjustment_clearing_types', $adjustmentsToRemove);
    }
}
