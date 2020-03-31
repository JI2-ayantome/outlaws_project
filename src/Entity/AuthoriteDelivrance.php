<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AuthoriteDelivranceRepository")
 * @ORM\Table(schema="metier")
 * @ORM\HasLifecycleCallbacks()
 */
class AuthoriteDelivrance
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenoms;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PieceIdentification", mappedBy="authorite")
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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenoms(): ?string
    {
        return $this->prenoms;
    }

    public function setPrenoms(string $prenoms): self
    {
        $this->prenoms = $prenoms;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

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
            $pieceIdentification->setAuthorite($this);
        }

        return $this;
    }

    public function removePieceIdentification(PieceIdentification $pieceIdentification): self
    {
        if ($this->pieceIdentifications->contains($pieceIdentification)) {
            $this->pieceIdentifications->removeElement($pieceIdentification);
            // set the owning side to null (unless already changed)
            if ($pieceIdentification->getAuthorite() === $this) {
                $pieceIdentification->setAuthorite(null);
            }
        }

        return $this;
    }
}
