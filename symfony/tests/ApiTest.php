<?php

namespace App\Tests;

use App\Repository\DeveloperRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiTest extends WebTestCase
{
    public function testApiHome(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/');

        $this->assertResponseIsSuccessful();
        $content = json_decode($client->getResponse()->getContent(),true);
        $this->assertNotEmpty($content);
        $this->assertEquals('Welcome to your new controller!', $content['message']);
        $this->assertEquals('src/Controller/ApiController.php', $content['path']);
    }

    public function testApiNotFound(): void
    {
        $client = static::createClient();
        $applicationId = '3075334';
        $crawler = $client->request('GET', '/api/not-found/');
        $this->assertResponseStatusCodeSame(404);

    }

    public function testApiGetApplication(): void
    {
        $client = static::createClient();
        $applicationId = '3075334';
        $crawler = $client->request('GET', '/api/application/' . $applicationId);
        $content = json_decode($client->getResponse()->getContent(),true);

        $this->assertResponseIsSuccessful();
        $this->assertIsArray($content);
        $this->assertNotEmpty($content);
        $this->assertArrayHasKey('id', $content);
        $this->assertEquals($applicationId, $content['id']);
        $this->assertArrayHasKey('authorInfo', $content);
        $this->assertIsArray($content['authorInfo']);
        $this->assertArrayHasKey('compatible', $content);
    }

    public function testApiGetApplicationNotFound(): void
    {
        $client = static::createClient();
        $applicationId = '3076999';
        $crawler = $client->request('GET', '/api/application/' . $applicationId);
        $content = json_decode($client->getResponse()->getContent(),true);

        $this->assertResponseStatusCodeSame(404);
        $this->assertIsArray($content);
        $this->assertNotEmpty($content);
        $this->assertArrayHasKey('code', $content);
        $this->assertEquals(404, $content['code']);
        $this->assertArrayHasKey('message', $content);
        $this->assertEquals("Application with id: " . $applicationId . " NOT FOUND in ApplicationProvider", $content['message']);

    }

    public function testApiGetApplicationNotFoundInBackup(): void
    {
        $currentEnvHost = $_ENV['PROVIDER_APP_HOST'];
        $_ENV['PROVIDER_APP_HOST'] = 'http://fakeserver.com'; //to simulate a non conection provider

        $client = static::createClient();
        $applicationId = '3076999';
        $crawler = $client->request('GET', '/api/application/' . $applicationId);
        $content = json_decode($client->getResponse()->getContent(),true);

        $this->assertResponseStatusCodeSame(404);
        $this->assertIsArray($content);
        $this->assertNotEmpty($content);
        $this->assertArrayHasKey('code', $content);
        $this->assertEquals(404, $content['code']);
        $this->assertArrayHasKey('message', $content);
        $this->assertEquals("Application with id: " . $applicationId . " NOT FOUND in BackupApplicationProvider", $content['message']);
        $_ENV['PROVIDER_APP_HOST'] = $currentEnvHost;

    }

    public function testApiGetApplicationDeveloperNotFound(): void
    {
        //To simulate when the AppProvider gives a developer id which not match with any developer in the developerProvider
        $client = static::createClient();
        $applicationId = '3075340';
        $crawler = $client->request('GET', '/api/application/' . $applicationId);
        $content = json_decode($client->getResponse()->getContent(),true);

        $this->assertResponseStatusCodeSame(404);
        $this->assertIsArray($content);
        $this->assertNotEmpty($content);
        $this->assertArrayHasKey('code', $content);
        $this->assertEquals(404, $content['code']);
        $this->assertArrayHasKey('message', $content);
        $this->assertEquals("Developer with id: 900 NOT FOUND in DeveloperProvider", $content['message']);
    }

    /*public function testApiGetApplicationDeveloperNotFoundInBackup(): void
    {
        //To simulate when the AppProvider gives a developer id which not match with any developer in the developerProvider

        $currentEnvHost = $_ENV['PROVIDER_DEVELOPER_HOST'];
        $_ENV['PROVIDER_DEVELOPER_HOST'] = 'http://fakeserver.com'; //to simulate a non conection provider

        $client = static::createClient();
        $applicationId = '3075340';
        $crawler = $client->request('GET', '/api/application/' . $applicationId);
        $content = json_decode($client->getResponse()->getContent(),true);

        $this->assertResponseStatusCodeSame(404);
        $this->assertIsArray($content);
        $this->assertNotEmpty($content);
        $this->assertArrayHasKey('code', $content);
        $this->assertEquals(404, $content['code']);
        $this->assertArrayHasKey('message', $content);
        $this->assertEquals("Developer with id: 900 NOT FOUND in BackupDeveloperProvider", $content['message']);

        $_ENV['PROVIDER_DEVELOPER_HOST'] = $currentEnvHost;
    }*/
}
