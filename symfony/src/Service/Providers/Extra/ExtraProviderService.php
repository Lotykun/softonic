<?php


namespace App\Service\Providers\Extra;

use App\Service\ProviderService;
use Symfony\Component\HttpFoundation\JsonResponse;

class ExtraProviderService extends ProviderService
{
    public function getData($dataId)
    {
        $url = $this->conf['host'] . $this->conf['url'] . $this->conf['params'];
        $response = $this->client->request($this->conf['method'], $url);
        $statusCode = $response->getStatusCode();
        $contentType = $response->getHeaders()['content-type'][0];
        $content = $response->getContent();
        $content = json_decode(json_encode(simplexml_load_string($content)),true);
        return $content;
    }

    public function updateEntityData($data)
    {

    }

    public function healthStatus(): bool
    {

    }
}