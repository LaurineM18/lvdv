<?php

namespace App\Entity;

use App\Repository\FormatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormatRepository::class)]
class Format
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'format', targetEntity: Vitrine::class)]
    private Collection $vitrines;

    public function __construct()
    {
        $this->vitrines = new ArrayCollection();
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
     * @return Collection<int, Vitrine>
     */
    public function getVitrines(): Collection
    {
        return $this->vitrines;
    }

    public function addVitrine(Vitrine $vitrine): self
    {
        if (!$this->vitrines->contains($vitrine)) {
            $this->vitrines->add($vitrine);
            $vitrine->setFormat($this);
        }

        return $this;
    }

    public function removeVitrine(Vitrine $vitrine): self
    {
        if ($this->vitrines->removeElement($vitrine)) {
            // set the owning side to null (unless already changed)
            if ($vitrine->getFormat() === $this) {
                $vitrine->setFormat(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
