<?php

namespace App\Tests;

use App\Entity\Developer;
use App\Repository\DeveloperRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DeveloperTest extends KernelTestCase
{
    public function testDeveloperInstance(): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());
        /** @var DeveloperRepository $developerManager */
        $developerManager = static::getContainer()->get(DeveloperRepository::class);

        $developer = $developerManager->create();
        $developer->setName('VideoLan');
        $developer->setUrl('http://www.videolan.org/');
        $developer->setDeveloperId(801);
        $developerManager->add($developer, true);

        $this->assertInstanceOf(Developer::class, $developer);
    }
}
