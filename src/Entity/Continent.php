<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContinentRepository")
 */
class Continent
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Discovery", mappedBy="continent", orphanRemoval=true)
     */
    private $discoveries;

    public function __construct()
    {
        $this->discoveries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Discovery[]
     */
    public function getDiscoveries(): Collection
    {
        return $this->discoveries;
    }

    public function addDiscovery(Discovery $discovery): self
    {
        if (!$this->discoverys->contains($discovery)) {
            $this->discoverys[] = $discovery;
            $discovery->setContinent($this);
        }

        return $this;
    }

    public function removeDiscovery(Discovery $discovery): self
    {
        if ($this->discoverys->contains($discovery)) {
            $this->discoverys->removeElement($discovery);
            // set the owning side to null (unless already changed)
            if ($discovery->getContinent() === $this) {
                $discovery->setContinent(null);
            }
        }

        return $this;
    }
}
