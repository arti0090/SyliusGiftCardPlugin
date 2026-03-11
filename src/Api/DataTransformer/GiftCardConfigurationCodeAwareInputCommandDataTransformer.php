<?php

declare(strict_types=1);

namespace Setono\SyliusGiftCardPlugin\Api\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use Setono\SyliusGiftCardPlugin\Api\Command\ConfigurationCodeAwareInterface;
use Setono\SyliusGiftCardPlugin\Model\GiftCardConfigurationInterface;
use Webmozart\Assert\Assert;

final class GiftCardConfigurationCodeAwareInputCommandDataTransformer implements DataTransformerInterface
{
    /**
     * @param ConfigurationCodeAwareInterface $object
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function transform($object, string $to, array $context = []): ConfigurationCodeAwareInterface
    {
        Assert::isInstanceOf($object, ConfigurationCodeAwareInterface::class);

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
