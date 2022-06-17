<?php

namespace App\Tests;

use App\Entity\Developer;
use App\Repository\DeveloperRepository;
use App\Service\Providers\Developer\DeveloperProviderService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProviderDeveloperTest extends KernelTestCase
{
    public function testUpdateDeveloperAfterProvider(): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());
        $developerAppService = static::getContainer()->get(DeveloperProviderService::class);

        /** @var DeveloperRepository $developerManager */
        $developerManager = static::getContainer()->get(DeveloperRepository::class);

        $developerId = 803;
        $testDeveloper = $developerManager->create();
        $testDeveloper->setName('VideoLan');
        $testDeveloper->setUrl('http://www.videolan.org/');
        $testDeveloper->setDeveloperId($developerId);
        $developerManager->add($testDeveloper, true);
        $currentUpdatedAt = $testDeveloper->getUpdatedAt();
        $this->assertInstanceOf(Developer::class, $testDeveloper);

        /** @var Developer $providerDeveloper */
        $providerDeveloper = $developerAppService->getData($developerId);
        $this->assertInstanceOf(Developer::class, $providerDeveloper);

        $this->assertEquals($developerId, $providerDeveloper->getDeveloperId());
        $this->assertGreaterThanOrEqual($currentUpdatedAt, $providerDeveloper->getUpdatedAt());
    }

    public function testDeveloperProviderOutConnection(): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());
        $currentEnvHost = $_ENV['PROVIDER_DEVELOPER_HOST'];
        $_ENV['PROVIDER_DEVELOPER_HOST'] = 'http://fakeserver.com';
        $developerAppService = static::getContainer()->get(DeveloperProviderService::class);

        /** @var DeveloperRepository $developerManager */
        $developerManager = static::getContainer()->get(DeveloperRepository::class);

        $developerId = 803;
        $testDeveloper = $developerManager->create();
        $testDeveloper->setName('VideoLan');
        $testDeveloper->setUrl('http://www.videolan.org/');
        $testDeveloper->setDeveloperId($developerId);
        $developerManager->add($testDeveloper, true);
        $currentUpdatedAt = $testDeveloper->getUpdatedAt();
        $this->assertInstanceOf(Developer::class, $testDeveloper);

        /** @var Developer $providerDeveloper */
        $providerDeveloper = $developerAppService->getData($developerId);
        $this->assertInstanceOf(Developer::class, $providerDeveloper);

        $this->assertEquals($developerId, $providerDeveloper->getDeveloperId());
        $this->assertEquals($currentUpdatedAt, $providerDeveloper->getUpdatedAt());
        $_ENV['PROVIDER_DEVELOPER_HOST'] = $currentEnvHost;
    }
}
