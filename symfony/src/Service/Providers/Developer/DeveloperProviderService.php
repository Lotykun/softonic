<?php


namespace App\Service\Providers\Developer;

use App\Service\ProviderService;
use App\Repository\DeveloperRepository;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class DeveloperProviderService extends ProviderService
{
    private $developerManager;

    public function __construct(ParameterBagInterface $params, HttpClientInterface $client, DeveloperRepository $developerRepository)
    {
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
                throw new \Exception("Developer with id: " . $dataId . " NOT FOUND in DeveloperProvider");
            }
            $developer = $this->updateEntityData($found);
        } else {
            $developers = $this->developerManager->findBy(array('developerId' => $dataId));
            if (count($developers) === 1){
                $developer = $developers[0];
            } elseif (count($developers) === 0){
                throw new \Exception("Developer with id: " . $dataId . " NOT FOUND in BackupDeveloperProvider");
            } else {
                throw new \Exception("There are more than one Developer with id: " . $dataId . " in BackupDeveloperProvider");
            }
        }
        return $developer;
    }

    public function updateEntityData($data)
    {
        $developers = $this->developerManager->findBy(array('developerId' => $data['id']));
        if (count($developers) === 0){
            $developer = $this->developerManager->create();
        } elseif (count($developers) === 1){
            $developer = $developers[0];
        } else {
            throw new \Exception("Developer with id: " . $data['id'] . " NOT FOUND in BackupDeveloperProvider");
        }
        $developer->setDeveloperId($data['id']);
        $developer->setName($data['name']);
        $developer->setUrl($data['url']);
        $developer->setUpdatedAt(new \DateTime());

        $this->developerManager->add($developer, true);
        return $developer;
    }

    public function healthStatus(): bool
    {
        $response = file_exists($this->conf['url']);
        return $response;
    }
}