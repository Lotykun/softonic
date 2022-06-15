<?php

namespace App\Entity;

use App\Repository\ApplicationCompatibleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="application_compatible_name", columns={"name"})})
 * @ORM\Entity(repositoryClass=ApplicationCompatibleRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class ApplicationCompatible extends EntityBase
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $compatible;

    /**
     * @ORM\ManyToMany(targetEntity="Application", mappedBy="compatibles", cascade={"persist"})
     **/
    protected $applications;


    /**
     * ApplicationCompatible constructor.
     */
    public function __construct()
    {
        $this->applications = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
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
     * @return mixed
     */
    public function getApplications()
    {
        return $this->applications;
    }

    /**
     * @param mixed $applications
     */
    public function setApplications($applications): void
    {
        $this->applications = $applications;
    }

    /**
     * @param Application $application
     * @return $this
     */
    public function addApplication(Application $application)
    {
        $this->applications->add($application);
        $application->addCompatible($this);
        return $this;
    }

    /**
     * @param Application $application
     * @return $this
     */
    public function removeApplication(Application $application)
    {
        $this->applications->removeElement($application);
        $application = $application->removeCompatible($this);
        return $this;
    }
}
