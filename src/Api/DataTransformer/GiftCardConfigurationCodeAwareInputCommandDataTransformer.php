<?php

declare(strict_types=1);

namespace Setono\SyliusGiftCardPlugin\Api\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use Setono\SyliusGiftCardPlugin\Api\Command\ConfigurationCodeAwareInterface;
use Setono\SyliusGiftCardPlugin\Model\GiftCardConfigurationInterface;
use Webmozart\Assert\Assert;

final class GiftCardConfigurationCodeAwareInputCommandDataTransformer implements DataTransformerInterface
{
    public function transform($object, string $to, array $context = []): ConfigurationCodeAwareInterface
    {
        Assert::isInstanceOf($object, ConfigurationCodeAwareInterface::class);
        Assert::keyExists($context, 'object_to_populate');
        Assert::isInstanceOf($context['object_to_populate'], GiftCardConfigurationInterface::class);

        /** @var GiftCardConfigurationInterface $giftCardConfiguration */
        $giftCardConfiguration = $context['object_to_populate'];

        $object->setConfigurationCode($giftCardConfiguration->getCode());

        return $object;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return $data instanceof ConfigurationCodeAwareInterface;
    }
}
