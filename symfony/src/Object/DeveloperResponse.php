<?php

namespace App\Object;


use App\Entity\Developer;
use App\Entity\EntityBase;
use App\Entity\Extra;

class DeveloperResponse
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $url;

    /**
     * @var Extra
     */
    private $extra;

    /**
     * @var string
     */
    private $createdAt;

    /**
     * @var string
     */
    private $updateAt;



    public function __construct(Developer $developer, Extra $extra = null)
    {
        $this->name = $developer->getName();
        $this->url = $developer->getUrl();
        $this->extra = null;
        if ($extra && isset($extra)){
            $this->extra = new ExtraResponse($extra);
        }
        $this->createdAt = $developer->getCreatedAt()->format(EntityBase::DATE_FORMAT);;
        $this->updateAt = $developer->getUpdatedAt()->format(EntityBase::DATE_FORMAT);;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getExtra(): string
    {
        return $this->extra;
    }

    /**
     * @param string $extra
     */
    public function setExtra(string $extra): void
    {
        $this->extra = $extra;
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
