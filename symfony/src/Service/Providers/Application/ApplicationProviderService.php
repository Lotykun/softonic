<?php


namespace App\Service\Providers\Application;

use App\Entity\Developer;
use App\Repository\ApplicationCompatibleRepository;
use App\Repository\ApplicationRepository;
use App\Repository\DeveloperRepository;
use App\Service\ProviderService;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
            /*Assuming there is an external API and there is a method to GET the application data as the format described in the statement*/
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
                throw new NotFoundHttpException("Application with id: " . $dataId . " NOT FOUND in ApplicationProvider");
            }
            $app = $this->updateEntityData($found);
        } else {
            $apps = $this->applicationManager->findBy(array('applicationId' => $dataId));
            if (count($apps) === 1){
                $app = $apps[0];
            } elseif (count($apps) === 0){
                throw new NotFoundHttpException("Application with id: " . $dataId . " NOT FOUND in BackupApplicationProvider");
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
            if (count($compatibles) === 1){
                $appCompatible = $compatibles[0];
            } elseif (count($compatibles) === 0){
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
        $result = false;
        $url = $this->conf['host'];

        try {
            $response = $this->client->request('GET', $url);
            $statusCode = $response->getStatusCode();
            if ($statusCode == JsonResponse::HTTP_OK || $statusCode == JsonResponse::HTTP_NOT_FOUND){
                $result = true;
            }
        } catch (\Exception $e){
            $result = false;
        }

        /*Assuming there is an external API and there is a method to GET the application data as the format described in the statement */
        /* There will be here the code to simulate if the endpoint is available right now */
        /* Using the client attribute from this service we can get a temporary request to test if the provider data is available */
        /* If the service is not available the response is false */
        /*END principal code*/

        return $result;
    }
}