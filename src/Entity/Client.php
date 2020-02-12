<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */
class Client
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Communication", mappedBy="client", cascade="persist")
     */
    private $communications;

    public function __construct()
    {
        $this->communications = new ArrayCollection();
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
     * @return Collection|Communication[]
     */
    public function getCommunications(): Collection
    {
        return $this->communications;
    }

    public function addCommunication(Communication $communication): self
    {
        if (!$this->communications->contains($communication)) {
            $this->communications[] = $communication;
            $communication->setClient($this);
        }

        return $this;
    }

    public function removeCommunication(Communication $communication): self
    {
        if ($this->communications->contains($communication)) {
            $this->communications->removeElement($communication);
            // set the owning side to null (unless already changed)
            if ($communication->getClient() === $this) {
                $communication->setClient(null);
            }
        }

        return $this;
    }
}
