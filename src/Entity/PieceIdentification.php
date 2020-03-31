<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PieceIdentificationRepository")
 * @ORM\Table(schema="metier")
 * @ORM\HasLifecycleCallbacks()
 */
class PieceIdentification
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
     * @ORM\Column(type="date")
     */
    private $dateDelivrance;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lieuDelivrance;

    /**
     * @ORM\Column(type="date")
     */
    private $dateExpiration;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\NaturePiece", inversedBy="pieceIdentifications")
     * @ORM\JoinColumn(nullable=false)
     */
    private $nature;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AuthoriteDelivrance", inversedBy="pieceIdentifications")
     * @ORM\JoinColumn(nullable=false)
     */
    private $authorite;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Fugitif", inversedBy="pieceIdentification")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fugitif;

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

    public function getDateDelivrance(): ?\DateTimeInterface
    {
        return $this->dateDelivrance;
    }

    public function setDateDelivrance(\DateTimeInterface $dateDelivrance): self
    {
        $this->dateDelivrance = $dateDelivrance;

        return $this;
    }

    public function getLieuDelivrance(): ?string
    {
        return $this->lieuDelivrance;
    }

    public function setLieuDelivrance(string $lieuDelivrance): self
    {
        $this->lieuDelivrance = $lieuDelivrance;

        return $this;
    }

    public function getDateExpiration(): ?\DateTimeInterface
    {
        return $this->dateExpiration;
    }

    public function setDateExpiration(\DateTimeInterface $dateExpiration): self
    {
        $this->dateExpiration = $dateExpiration;

        return $this;
    }

    public function getNature(): ?NaturePiece
    {
        return $this->nature;
    }

    public function setNature(?NaturePiece $nature): self
    {
        $this->nature = $nature;

        return $this;
    }

    public function getAuthorite(): ?AuthoriteDelivrance
    {
        return $this->authorite;
    }

    public function setAuthorite(?AuthoriteDelivrance $authorite): self
    {
        $this->authorite = $authorite;

        return $this;
    }

    public function getFugitif(): ?Fugitif
    {
        return $this->fugitif;
    }

    public function setFugitif(?Fugitif $fugitif): self
    {
        $this->fugitif = $fugitif;

        return $this;
    }
}
