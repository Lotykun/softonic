<?php

namespace App\Object;


use App\Entity\Application;
use App\Entity\ApplicationCompatible;
use App\Entity\Developer;
use App\Entity\EntityBase;
use App\Entity\Extra;

class ApplicationResponse
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var Developer
     */
    private $author_info;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $version;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $short_description;

    /**
     * @var string
     */
    private $license;

    /**
     * @var string
     */
    private $thumbnail;

    /**
     * @var integer
     */
    private $rating;

    /**
     * @var string
     */
    private $total_downloads;

    /**
     * @var string
     */
    private $compatible;

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


    public function __construct(Application $app, Developer $developer, Extra $extra = null)
    {
        $this->id = $app->getApplicationId();
        $this->author_info = new DeveloperResponse($developer);
        $this->title = $app->getTitle();
        $this->version = $app->getVersion();
        $this->url = $app->getUrl();
        $this->short_description = $app->getShortDescription();
        $this->license = $app->getLicense();
        $this->thumbnail = $app->getThumbnail();
        $this->rating = $app->getRating();
        $this->total_downloads = $app->getTotalDownloads();
        $this->compatible = null;
        $compatibilities = array();
        /** @var ApplicationCompatible $compatible */
        foreach ($app->getCompatibles() as $compatible){
            $compatibilities[] = $compatible->getCompatible();
        }
        if (count($compatibilities) > 0){
            $this->compatible = implode("|", $compatibilities);
        }
        $this->extra = null;
        if ($extra && isset($extra)){
            $this->extra = new ExtraResponse($extra);
        }

        $this->createdAt = $app->getCreatedAt()->format(EntityBase::DATE_FORMAT);
        $this->updateAt = $app->getUpdatedAt()->format(EntityBase::DATE_FORMAT);
    }


    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
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

    /**
     * @return mixed
     */
    public function getAuthorInfo()
    {
        return $this->author_info;
    }

    /**
     * @param mixed $author_info
     */
    public function setAuthorInfo($author_info): void
    {
        $this->author_info = $author_info;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @param string $version
     */
    public function setVersion(string $version): void
    {
        $this->version = $version;
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
    public function getShortDescription(): string
    {
        return $this->short_description;
    }

    /**
     * @param string $short_description
     */
    public function setShortDescription(string $short_description): void
    {
        $this->short_description = $short_description;
    }

    /**
     * @return string
     */
    public function getLicense(): string
    {
        return $this->license;
    }

    /**
     * @param string $license
     */
    public function setLicense(string $license): void
    {
        $this->license = $license;
    }

    /**
     * @return string
     */
    public function getThumbnail(): string
    {
        return $this->thumbnail;
    }

    /**
     * @param string $thumbnail
     */
    public function setThumbnail(string $thumbnail): void
    {
        $this->thumbnail = $thumbnail;
    }

    /**
     * @return int
     */
    public function getRating(): int
    {
        return $this->rating;
    }

    /**
     * @param int $rating
     */
    public function setRating(int $rating): void
    {
        $this->rating = $rating;
    }

    /**
     * @return string
     */
    public function getTotalDownloads(): string
    {
        return $this->total_downloads;
    }

    /**
     * @param string $total_downloads
     */
    public function setTotalDownloads(string $total_downloads): void
    {
        $this->total_downloads = $total_downloads;
    }

    /**
     * @return string
     */
    public function getCompatible(): string
    {
        return $this->compatible;
    }

    /**
     * @param string $compatible
     */
    public function setCompatible(string $compatible): void
    {
        $this->compatible = $compatible;
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
}
