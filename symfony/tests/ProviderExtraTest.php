<?php

namespace App\Tests;

use App\Entity\Application;
use App\Entity\ApplicationCompatible;
use App\Entity\Developer;
use App\Repository\ApplicationCompatibleRepository;
use App\Repository\ApplicationRepository;
use App\Repository\DeveloperRepository;
use App\Service\Providers\Application\ApplicationProviderService;
use App\Service\Providers\Developer\DeveloperProviderService;
use App\Service\Providers\Extra\ExtraProviderService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProviderExtraTest extends KernelTestCase
{
    public function testUpdateDeveloperAfterProvider(): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());
        $extraAppService = static::getContainer()->get(ExtraProviderService::class);
        $providerContent = $extraAppService->getData('78');
        $this->assertIsArray($providerContent);
        $this->assertNotEmpty($providerContent);
    }
}
