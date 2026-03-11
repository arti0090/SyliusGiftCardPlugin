<?php

declare(strict_types=1);

namespace Setono\SyliusGiftCardPlugin\Api\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use Setono\SyliusGiftCardPlugin\Api\Command\GiftCardCodeAwareInterface;
use Setono\SyliusGiftCardPlugin\Model\GiftCardInterface;
use Webmozart\Assert\Assert;

final class GiftCardCodeAwareInputCommandDataTransformer implements DataTransformerInterface
{
    /**
     * @param GiftCardCodeAwareInterface $object
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function transform($object, string $to, array $context = []): GiftCardCodeAwareInterface
    {
        Assert::isInstanceOf($object, GiftCardCodeAwareInterface::class);

        /** @var GiftCardInterface $giftCard */
        $giftCard = $context['object_to_populate'];

        $object->setGiftCardCode($giftCard->getCode());

        return $object;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return $data instanceof GiftCardCodeAwareInterface;
    }
}
