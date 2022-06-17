<?php

namespace App\Tests;

use App\Entity\Application;
use App\Entity\ApplicationCompatible;
use App\Repository\ApplicationCompatibleRepository;
use App\Repository\ApplicationRepository;
use App\Repository\DeveloperRepository;
use App\Service\Providers\Application\ApplicationProviderService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProviderApplicationTest extends KernelTestCase
{
    public function testUpdateApplicationAfterProvider(): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());
        $providerAppService = static::getContainer()->get(ApplicationProviderService::class);

        /** @var ApplicationRepository $appManager */
        $appManager = static::getContainer()->get(ApplicationRepository::class);
        /** @var DeveloperRepository $developerManager */
        $developerManager = static::getContainer()->get(DeveloperRepository::class);
        /** @var ApplicationCompatibleRepository $compatibleManager */
        $compatibleManager = static::getContainer()->get(ApplicationCompatibleRepository::class);

        $developer = $developerManager->create();
        $developer->setName('VideoLan');
        $developer->setUrl('http://www.videolan.org/');
        $developer->setDeveloperId(805);
        $developerManager->add($developer, true);

        $compatible = $compatibleManager->create();
        $compatible->setCompatible('Windows 11');
        $compatibleManager->add($compatible, true);

        $currentTotalDownloads = '5784268';
        $currentVersion = '2.4.0';
        $applicationId = '3075340';
        $testApp = $appManager->create();
        $testApp->setApplicationId($applicationId);
        $testApp->setTotalDownloads($currentTotalDownloads);
        $testApp->setThumbnail('https://screenshots.en.sftcdn.net/en/scrn/25000/25339/vlc-media-player-11-100x100.png');
        $testApp->setShortDescription('Simply the best multi-format media player');
        $testApp->setRating(8);
        $testApp->setLicense('Free (GPL)');
        $testApp->setUrl('http://vlc.en.softonic.com');
        $testApp->setTitle('VLC');
        $testApp->setVersion($currentVersion);
        $testApp->setDeveloper($developer);
        $testApp->addCompatible($compatible);
        $appManager->add($testApp, true);
        $currentUpdatedAt = $testApp->getUpdatedAt();
        $this->assertInstanceOf(Application::class, $testApp);


        /** @var Application $providerApp */
        $providerApp = $providerAppService->getData($applicationId);
        $this->assertInstanceOf(Application::class, $providerApp);

        $this->assertEquals($applicationId, $providerApp->getApplicationId());
        $this->assertGreaterThanOrEqual($currentUpdatedAt, $providerApp->getUpdatedAt());
        $this->assertGreaterThanOrEqual($currentVersion, $providerApp->getVersion());
        $this->assertGreaterThanOrEqual($currentTotalDownloads, $providerApp->getTotalDownloads());
    }

    public function testApplicationProviderOutConnection(): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());
        $currentEnvHost = $_ENV['PROVIDER_APP_HOST'];
        $_ENV['PROVIDER_APP_HOST'] = 'http://fakeserver.com';
        $providerAppService = static::getContainer()->get(ApplicationProviderService::class);

        /** @var ApplicationRepository $appManager */
        $appManager = static::getContainer()->get(ApplicationRepository::class);
        /** @var DeveloperRepository $developerManager */
        $developerManager = static::getContainer()->get(DeveloperRepository::class);
        /** @var ApplicationCompatibleRepository $compatibleManager */
        $compatibleManager = static::getContainer()->get(ApplicationCompatibleRepository::class);

        $developer = $developerManager->create();
        $developer->setName('VideoLan');
        $developer->setUrl('http://www.videolan.org/');
        $developer->setDeveloperId(805);
        $developerManager->add($developer, true);

        $compatible = $compatibleManager->create();
        $compatible->setCompatible('Windows 11');
        $compatibleManager->add($compatible, true);

        $currentTotalDownloads = '5784268';
        $currentVersion = '2.4.0';
        $applicationId = '3075334';
        $testApp = $appManager->create();
        $testApp->setApplicationId($applicationId);
        $testApp->setTotalDownloads($currentTotalDownloads);
        $testApp->setThumbnail('https://screenshots.en.sftcdn.net/en/scrn/25000/25339/vlc-media-player-11-100x100.png');
        $testApp->setShortDescription('Simply the best multi-format media player');
        $testApp->setRating(8);
        $testApp->setLicense('Free (GPL)');
        $testApp->setUrl('http://vlc.en.softonic.com');
        $testApp->setTitle('VLC');
        $testApp->setVersion($currentVersion);
        $testApp->setDeveloper($developer);
        $testApp->addCompatible($compatible);
        $appManager->add($testApp, true);
        $currentUpdatedAt = $testApp->getUpdatedAt();
        $this->assertInstanceOf(Application::class, $testApp);

        /** @var Application $providerApp */
        $providerApp = $providerAppService->getData($applicationId);
        $this->assertInstanceOf(Application::class, $providerApp);

        $this->assertEquals($applicationId, $providerApp->getApplicationId());
        $this->assertEquals($currentUpdatedAt, $providerApp->getUpdatedAt());
        $this->assertEquals($currentVersion, $providerApp->getVersion());
        $this->assertEquals($currentTotalDownloads, $providerApp->getTotalDownloads());
        $_ENV['PROVIDER_APP_HOST'] = $currentEnvHost;
    }
}
