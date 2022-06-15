<?php

namespace App\Object;


use App\Entity\EntityBase;
use App\Entity\Extra;

class ExtraResponse
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var string
     */
    private $createdAt;

    /**
     * @var string
     */
    private $updateAt;

    public function __construct(Extra $extra)
    {
        $xml = $extra->getXml();
        $this->data = new \SimpleXMLElement($xml);
        $this->createdAt = $extra->getCreatedAt()->format(EntityBase::DATE_FORMAT);;
        $this->updateAt = $extra->getUpdatedAt()->format(EntityBase::DATE_FORMAT);;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     */
    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getUpdateAt(): string
    {
        return $this->updateAt;
    }

    /**
     * @param string $updateAt
     */
    public function setUpdateAt(string $updateAt): void
    {
        $this->updateAt = $updateAt;
    }
}
