<?php


namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ProviderService implements ProviderServiceBaseInterface
{
    protected $conf;
    protected $client;
    /** @var bool  */
    protected $enabled;

    /**
     * ProviderService constructor.
     * @param ParameterBagInterface $params
     * @param HttpClientInterface $client
     */
    public function __construct(ParameterBagInterface $params, HttpClientInterface $client)
    {
        $providersConf = $params->get('providers');
        $this->conf = $providersConf[$this->getClassName()];
        $this->client = $client;
        $this->enabled = ($this->conf['enable'] == 'true') ? true : false;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     */
    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    /**
     * @return mixed
     */
    public function getConf()
    {
        return $this->conf;
    }

    /**
     * @param mixed $conf
     */
    public function setConf($conf): void
    {
        $this->conf = $conf;
    }

    /**
     * @return HttpClientInterface
     */
    public function getClient(): HttpClientInterface
    {
        return $this->client;
    }

    /**
     * @param HttpClientInterface $client
     */
    public function setClient(HttpClientInterface $client): void
    {
        $this->client = $client;
    }

    /**
     * @return mixed
     */
    public function getClassName() {
        $path = explode('\\', get_class($this));
        return array_pop($path);
    }

    public function getData($dataId)
    {
        // TODO: Implement getData() method.
    }

    public function updateEntityData($data)
    {
        // TODO: Implement updateEntityData() method.
    }

    public function healthStatus(): bool
    {
        // TODO: Implement healthStatus() method.
    }
}