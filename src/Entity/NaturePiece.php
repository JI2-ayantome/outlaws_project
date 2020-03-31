<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NaturePieceRepository")
 * @ORM\Table(schema="metier")
 * @ORM\HasLifecycleCallbacks()
 */
class NaturePiece
{
    use TimestampTrait;
    use UserActionsTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PieceIdentification", mappedBy="nature")
     */
    private $pieceIdentifications;

    public function __construct()
    {
        $this->pieceIdentifications = new ArrayCollection();
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
     * @return Collection|PieceIdentification[]
     */
    public function getPieceIdentifications(): Collection
    {
        return $this->pieceIdentifications;
    }

    public function addPieceIdentification(PieceIdentification $pieceIdentification): self
    {
        if (!$this->pieceIdentifications->contains($pieceIdentification)) {
            $this->pieceIdentifications[] = $pieceIdentification;
            $pieceIdentification->setNature($this);
        }

        return $this;
    }

    public function removePieceIdentification(PieceIdentification $pieceIdentification): self
    {
        if ($this->pieceIdentifications->contains($pieceIdentification)) {
            $this->pieceIdentifications->removeElement($pieceIdentification);
            // set the owning side to null (unless already changed)
            if ($pieceIdentification->getNature() === $this) {
                $pieceIdentification->setNature(null);
            }
        }

        return $this;
    }
}
