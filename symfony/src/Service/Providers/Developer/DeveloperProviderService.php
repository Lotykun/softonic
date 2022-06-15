<?php


namespace App\Service\Providers\Developer;

use App\Service\ProviderService;
use App\Repository\DeveloperRepository;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
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
            $found = false;
            $url = $this->conf['host'] . $this->conf['url'] . $this->conf['params'];
            $options = array();
            if ($this->conf['authorization'] != ''){
                $options['headers'] = array('Authorization' => $this->conf['authorization']);
            }

            $response = $this->client->request($this->conf['method'], $url);
            $statusCode = $response->getStatusCode();
            if ($statusCode == JsonResponse::HTTP_OK){
                $contentType = $response->getHeaders()['content-type'][0];
                $content = $response->getContent();
                $data = $response->toArray();
                /*FOR TESTING LOOKING IN ALL COLLECTION*/
                foreach ($data as $entry){
                    if (isset($entry['id']) && $entry['id'] !== ''){
                        if ($entry['id'] == $dataId){
                            $found = $entry;
                            break;
                        }
                    }
                }
                /*END TESTING*/
            }
            /*END principal code*/
            if (!$found){
                throw new \Exception("Application with id: " . $dataId . " NOT FOUND in ApplicationProvider");
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
        $result = false;
        $url = $this->conf['host'];

        try {
            $response = $this->client->request('GET', $url);
            $statusCode = $response->getStatusCode();
            if ($statusCode == JsonResponse::HTTP_OK){
                $result = true;
            }
        } catch (\Exception $e){
            $result = false;
        }

        /*Assuming there is an external API and there is a method to GET the Developer data as the format described in the statement */
        /* There will be here the code to simulate if the endpoint is available right now */
        /* Using the client attribute from this service we can get a temporary request to test if the provider data is available */
        /* If the service is not available the response is false */
        /*END principal code*/

        return $result;
    }
}