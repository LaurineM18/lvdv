<?php

namespace App\Entity;

use App\Repository\VitrineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VitrineRepository::class)]
class Vitrine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column]
    private ?bool $New = null;

    #[ORM\Column]
    private ?int $Price = null;

    #[ORM\Column]
    private ?bool $Available = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Description = null;

    #[ORM\ManyToOne(inversedBy: 'vitrines')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Format $format = null;

    #[ORM\ManyToOne(inversedBy: 'vitrines')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Theme $theme = null;

    #[ORM\OneToMany(mappedBy: 'vitrines', targetEntity: Image::class, orphanRemoval: true, cascade:['persist'])]
    private Collection $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }


    public function isNew(): ?bool
    {
        return $this->New;
    }

    public function setNew(bool $New): self
    {
        $this->New = $New;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->Price;
    }

    public function setPrice(int $Price): self
    {
        $this->Price = $Price;

        return $this;
    }

    public function isAvailable(): ?bool
    {
        return $this->Available;
    }

    public function setAvailable(bool $Available): self
    {
        $this->Available = $Available;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getFormat(): ?Format
    {
        return $this->format;
    }

    public function setFormat(?Format $format): self
    {
        $this->format = $format;

        return $this;
    }

    public function getTheme(): ?Theme
    {
        return $this->theme;
    }

    public function setTheme(?Theme $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setVitrines($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getVitrines() === $this) {
                $image->setVitrines(null);
            }
        }

        return $this;
    }


}
