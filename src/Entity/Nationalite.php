<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
// use Symfony\Component\Serializer\Annotation\MaxDepth;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NationaliteRepository")
 * @ORM\Table(schema="metier")
 * @ORM\HasLifecycleCallbacks()
 */
class Nationalite
{
    use TimestampTrait;
    use UserActionsTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("search:read")
     * @Groups("infos_mandat")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("search:read")
     * @Groups("infos_mandat")
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\NationaliteFugitif", mappedBy="nationalite")
     */
    private $natFugitifs;

    public function __construct()
    {
        $this->natFugitifs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection|NationaliteFugitif[]
     */
    public function getNatFugitifs(): Collection
    {
        return $this->natFugitifs;
    }

    public function addNatFugitif(NationaliteFugitif $natFugitif): self
    {
        if (!$this->natFugitifs->contains($natFugitif)) {
            $this->natFugitifs[] = $natFugitif;
            $natFugitif->setNationalite($this);
        }

        return $this;
    }

    public function removeNatFugitif(NationaliteFugitif $natFugitif): self
    {
        if ($this->natFugitifs->contains($natFugitif)) {
            $this->natFugitifs->removeElement($natFugitif);
            // set the owning side to null (unless already changed)
            if ($natFugitif->getNationalite() === $this) {
                $natFugitif->setNationalite(null);
            }
        }

        return $this;
    }
}
