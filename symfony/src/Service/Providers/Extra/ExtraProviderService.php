<?php


namespace App\Service\Providers\Extra;

use App\Service\ProviderService;

class ExtraProviderService extends ProviderService
{
    public function getData($dataId): array
    {
        /*$url = $this->conf['url'] . $this->conf['params'];
        $response = $this->client->request($this->conf['method'], $url);
        $statusCode = $response->getStatusCode();
        $contentType = $response->getHeaders()['content-type'][0];
        $content = $response->getContent();
        $content = $response->toArray();
        */
    }

    public function updateEntityData($data)
    {

    }

    public function healthStatus(): bool
    {

    }
}