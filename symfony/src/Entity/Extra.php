<?php

namespace App\Entity;

use App\Repository\ExtraRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExtraRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Extra extends EntityBase
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=16000)
     */
    private $xml;

    /**
     * @return mixed
     */
    public function getXml(): ?string
    {
        return $this->xml;
    }

    /**
     * @param string $xml
     * @return $this
     */
    public function setXml(string $xml): self
    {
        $this->xml = $xml;

        return $this;
    }


}
