<?php


namespace App\Service;


/**
 * Interface ProviderServiceBaseInterface
 * @package App\Service
 */
interface ProviderServiceBaseInterface
{
    /**
     * @return bool
     */
    public function healthStatus(): bool;

    /**
     * @param $dataId
     * @return array
     */
    public function getData($dataId);

    /**
     * @param $data
     * @return mixed
     */
    public function updateEntityData($data);
}