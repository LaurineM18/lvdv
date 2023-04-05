<?php

namespace App\Entity;

use App\Repository\SubjectVitrineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubjectVitrineRepository::class)]
class SubjectVitrine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\ManyToMany(targetEntity: Vitrine::class, mappedBy: 'Subject')]
    private Collection $vitrines;

    public function __construct()
    {
        $this->vitrines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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
            $vitrine->addSubject($this);
        }

        return $this;
    }

    public function removeVitrine(Vitrine $vitrine): self
    {
        if ($this->vitrines->removeElement($vitrine)) {
            $vitrine->removeSubject($this);
        }

        return $this;
    }
}
