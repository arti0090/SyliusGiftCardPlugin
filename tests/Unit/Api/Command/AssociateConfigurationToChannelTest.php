<?php

declare(strict_types=1);

namespace Setono\SyliusGiftCardPlugin\Tests\Unit\Api\Command;

use PHPUnit\Framework\TestCase;
use Setono\SyliusGiftCardPlugin\Api\Command\AssociateConfigurationToChannel;

class AssociateConfigurationToChannelTest extends TestCase
{
    public function test_it_is_initializable(): void
    {
        $command = new AssociateConfigurationToChannel('locale_code', 'channel_code');

        $this->assertInstanceOf(AssociateConfigurationToChannel::class, $command);
    }

    public function test_it_has_nullable_configuration_code(): void
    {
        $command = new AssociateConfigurationToChannel('locale_code', 'channel_code');

        $this->assertNull($command->configurationCode);
    }
}
