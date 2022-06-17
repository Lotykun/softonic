<?php

namespace App\Tests;

use App\Entity\Application;
use App\Entity\ApplicationCompatible;
use App\Repository\ApplicationCompatibleRepository;
use App\Repository\ApplicationRepository;
use App\Repository\DeveloperRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ApplicationTest extends KernelTestCase
{
    public function testApplicationInstance(): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());
        /** @var ApplicationRepository $appManager */
        $appManager = static::getContainer()->get(ApplicationRepository::class);
        /** @var DeveloperRepository $developerManager */
        $developerManager = static::getContainer()->get(DeveloperRepository::class);
        /** @var ApplicationCompatibleRepository $compatibleManager */
        $compatibleManager = static::getContainer()->get(ApplicationCompatibleRepository::class);

        $developer = $developerManager->create();
        $developer->setName('VideoLan');
        $developer->setUrl('http://www.videolan.org/');
        $developer->setDeveloperId(801);
        $developerManager->add($developer, true);

        $compatible = $compatibleManager->create();
        $compatible->setCompatible('Windows 11');
        $compatibleManager->add($compatible, true);

        $app = $appManager->create();
        $app->setApplicationId('3075333');
        $app->setTotalDownloads('5784268');
        $app->setThumbnail('https://screenshots.en.sftcdn.net/en/scrn/25000/25339/vlc-media-player-11-100x100.png');
        $app->setShortDescription('Simply the best multi-format media player');
        $app->setRating(8);
        $app->setLicense('Free (GPL)');
        $app->setUrl('http://vlc.en.softonic.com');
        $app->setTitle('VLC');
        $app->setVersion('2.4.0');
        $app->setDeveloper($developer);
        $app->addCompatible($compatible);
        $appManager->add($app, true);
        $this->assertInstanceOf(Application::class, $app);
    }
}
