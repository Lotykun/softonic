<?php

namespace App\Tests;

use App\Entity\ApplicationCompatible;
use App\Repository\ApplicationCompatibleRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ApplicationCompatibleTest extends KernelTestCase
{
    public function testApplicationCompatibleInstance(): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());
        /** @var ApplicationCompatibleRepository $compatibleManager */
        $compatibleManager = static::getContainer()->get(ApplicationCompatibleRepository::class);
        $compatible = $compatibleManager->create();
        $compatible->setCompatible('Windows 11');
        $compatibleManager->add($compatible, true);

        $this->assertInstanceOf(ApplicationCompatible::class, $compatible);
        // $routerService = static::getContainer()->get('router');
        // $myCustomService = static::getContainer()->get(CustomService::class);
    }
}
