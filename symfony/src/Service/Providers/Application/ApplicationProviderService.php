<?php


namespace App\Service\Providers\Application;

use App\Entity\Developer;
use App\Repository\ApplicationCompatibleRepository;
use App\Repository\ApplicationRepository;
use App\Repository\DeveloperRepository;
use App\Service\ProviderService;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApplicationProviderService extends ProviderService
{
    private $applicationManager;
    private $applicationCompatibleManager;
    private $developerManager;

    public function __construct(ParameterBagInterface $params, HttpClientInterface $client, DeveloperRepository $developerRepository, ApplicationRepository $applicationRepository, ApplicationCompatibleRepository $appCompatibleRepository)
    {
        $this->applicationManager = $applicationRepository;
        $this->applicationCompatibleManager = $appCompatibleRepository;
        $this->developerManager = $developerRepository;
        parent::__construct($params, $client);
    }

    public function getData($dataId)
    {
        if ($this->healthStatus()){
            $data = json_decode(file_get_contents($this->conf['url']), true);
            $found = false;
            foreach ($data as $entry){
                if (isset($entry['id']) && $entry['id'] !== ''){
                    if ($entry['id'] == $dataId){
                        $found = $entry;
                        break;
                    }
                }
            }
            if (!$found){
                throw new \Exception("Application with id: " . $dataId . " NOT FOUND in ApplicationProvider");
            }
            $app = $this->updateEntityData($found);
        } else {
            $apps = $this->applicationManager->findBy(array('applicationId' => $dataId));
            if (count($apps) === 1){
                $app = $apps[0];
            } elseif (count($apps) === 0){
                throw new \Exception("Application with id: " . $dataId . " NOT FOUND in BackupApplicationProvider");
            } else {
                throw new \Exception("There are more than one Application with id: " . $dataId . " in BackupApplicationProvider");
            }
        }
        return $app;
    }

    public function updateEntityData($data)
    {
        $apps = $this->applicationManager->findBy(array('applicationId' => $data['id']));
        if (count($apps) === 0){
            $app = $this->applicationManager->create();
        } elseif (count($apps) === 1){
            $app = $apps[0];
        } else {
            throw new \Exception("There are more than one Application with id: " . $data['id'] . " in BackupApplicationProvider");
        }

        /** @var Developer $developer */
        $developers = $this->developerManager->findBy(array('developerId' => $data['developer_id']));
        if (count($developers) === 0){
            $developer = $this->developerManager->create();
            $developer->setDeveloperId($data['developer_id']);
            $this->developerManager->add($developer, true);
        } elseif (count($developers) === 1){
            $developer = $developers[0];
        } else {
            throw new \Exception("There are more than one Developer with id: " . $data['developer_id'] . " in BackupDeveloperProvider");
        }

        $app->setDeveloper($developer);
        $app->setTitle($data['title']);
        $app->setUrl($data['url']);
        $app->setApplicationId(intval($data['id']));
        $app->setLicense($data['license']);
        $app->setRating(intval($data['rating']));
        $app->setShortDescription($data['short_description']);
        $app->setThumbnail($data['thumbnail']);
        $app->setTotalDownloads($data['total_downloads']);
        $app->setVersion($data['version']);
        foreach ($app->getCompatibles() as $compatible){
            $app->removeCompatible($compatible);
        }
        $this->applicationManager->add($app, true);

        foreach ($data['compatible'] as $compatible){
            $compatibles = $this->applicationCompatibleManager->findBy(array('compatible' => $compatible));
            if (count($developers) === 1){
                $appCompatible = $compatibles[0];
            } elseif (count($developers) === 0){
                $appCompatible = $this->applicationCompatibleManager->create();
            } else {
                throw new \Exception("There are more than one Compatible with name: " . $compatible);
            }
            $appCompatible->setCompatible($compatible);
            $this->applicationCompatibleManager->add($appCompatible, true);
            $app->addCompatible($appCompatible);
        }
        $this->applicationManager->add($app, true);

        return $app;
    }

    public function healthStatus(): bool
    {
        $response = file_exists($this->conf['url']);
        return $response;
    }
}