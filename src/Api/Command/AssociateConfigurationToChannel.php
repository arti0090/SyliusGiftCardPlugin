<?php

declare(strict_types=1);

namespace Setono\SyliusGiftCardPlugin\Api\Command;

use Setono\SyliusGiftCardPlugin\Api\Attribute\ConfigurationCodeAware;
use Sylius\Bundle\ApiBundle\Attribute\ChannelCodeAware;
use Sylius\Bundle\ApiBundle\Attribute\LocaleCodeAware;

#[ConfigurationCodeAware]
#[ChannelCodeAware]
#[LocaleCodeAware]
final readonly class AssociateConfigurationToChannel
{
    public function __construct(
        public string $localeCode,
        public string $channelCode,
        public ?string $configurationCode = null,
    ) {
    }
}
