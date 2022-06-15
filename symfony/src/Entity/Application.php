<?php

namespace App\Entity;

use App\Repository\ApplicationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ApplicationRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Application extends EntityBase
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $applicationId;

    /**
     * @var Developer
     *
     * @ORM\ManyToOne(targetEntity="Developer", inversedBy="Applications")
     * @ORM\JoinColumn(name="developer_id", referencedColumnName="id", nullable=true)
     */
    private $developer;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $version;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $short_description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $license;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $thumbnail;

    /**
     * @ORM\Column(type="integer")
     */
    private $rating;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $total_downloads;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="ApplicationCompatible", inversedBy="applications", cascade={"persist"})
     * @ORM\JoinTable(name="application_compatibles")
     **/
    private $compatibles;

    /**
     * Application constructor.
     */
    public function __construct()
    {
        $this->compatibles = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getApplicationId()
    {
        return $this->applicationId;
    }

    /**
     * @param mixed $applicationId
     */
    public function setApplicationId($applicationId): void
    {
        $this->applicationId = $applicationId;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getVersion(): ?string
    {
        return $this->version;
    }

    /**
     * @param string $version
     * @return $this
     */
    public function setVersion(string $version): self
    {
        $this->version = $version;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getShortDescription(): ?string
    {
        return $this->short_description;
    }

    /**
     * @param string $short_description
     * @return $this
     */
    public function setShortDescription(string $short_description): self
    {
        $this->short_description = $short_description;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLicense(): ?string
    {
        return $this->license;
    }

    /**
     * @param string $license
     * @return $this
     */
    public function setLicense(string $license): self
    {
        $this->license = $license;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    /**
     * @param string $thumbnail
     * @return $this
     */
    public function setThumbnail(string $thumbnail): self
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getRating(): ?int
    {
        return $this->rating;
    }

    /**
     * @param int $rating
     * @return $this
     */
    public function setRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTotalDownloads(): ?string
    {
        return $this->total_downloads;
    }

    /**
     * @param string $total_downloads
     * @return $this
     */
    public function setTotalDownloads(string $total_downloads): self
    {
        $this->total_downloads = $total_downloads;

        return $this;
    }

    /**
     * @return Developer|null
     */
    public function getDeveloper(): ?Developer
    {
        return $this->developer;
    }

    /**
     * @param Developer|null $developer
     */
    public function setDeveloper(?Developer $developer): void
    {
        $this->developer = $developer;
    }

    /**
     * @return ArrayCollection
     */
    public function getCompatibles()
    {
        return $this->compatibles;
    }

    /**
     * @param ArrayCollection $compatibles
     * @return $this
     */
    public function setCompatibles(ArrayCollection $compatibles): self
    {
        $this->compatibles = $compatibles;

        return $this;
    }

    /**
     * @param ApplicationCompatible $applicationCompatible
     * @return $this
     */
    public function addCompatible(ApplicationCompatible $applicationCompatible)
    {
        $this->compatibles->add($applicationCompatible);
        return $this;
    }

    /**
     * @param ApplicationCompatible $applicationCompatible
     * @return $this
     */
    public function removeCompatible(ApplicationCompatible $applicationCompatible)
    {
        $this->compatibles->removeElement($applicationCompatible);
        return $this;
    }
}
