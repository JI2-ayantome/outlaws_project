<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FugitifRepository")
 * @ORM\Table(schema="metier")
 * @ORM\HasLifecycleCallbacks()
 */
class Fugitif
{
    use TimestampTrait, UserActionsTrait;
    
    /**
     * @var integer ID de l'entité
     * 
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("search:read")
     * @Groups("infos_mandat")
     */
    private $id;

    /**
     * @var string Nom du fugitif
     * 
     * @ORM\Column(type="string", length=255)
     * @Groups("search:read")
     * @Groups("infos_mandat")
     */
    private $nom;

    /**
     * @var string Prénoms du fugitif
     * 
     * @ORM\Column(type="string", length=255)
     * @Groups("search:read")
     * @Groups("infos_mandat")
     */
    private $prenoms;

    /**
     * @var string Nom marital du fugitif de sexe féminin
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("search:read")
     * @Groups("infos_mandat")
     */
    private $nomMarital;

    /**
     * @var string Alias du fugitif
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("search:read")
     * @Groups("infos_mandat")
     */
    private $alias;

    /**
     * @var string Surnom du fugitif
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("search:read")
     * @Groups("infos_mandat")
     */
    private $surnom;

    /**
     * @var \DateTime Date de naissance du fugitif
     * 
     * @ORM\Column(type="date", nullable=true)
     * @Groups("search:read")
     * @Groups("infos_mandat")
     */
    private $dateNaissance;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("search:read")
     * @Groups("infos_mandat")
     */
    private $lieuNaissance;

    /**
     * @var string
     * 
     * @ORM\Column(type="text", nullable=true)
     * @Groups("search:read")
     * @Groups("infos_mandat")
     */
    private $adresse;

    /**
     * @var float
     * 
     * @ORM\Column(type="float", nullable=true)
     * @Groups("search:read")
     * @Groups("infos_mandat")
     */
    private $taille;

    /**
     * @var float
     * 
     * @ORM\Column(type="float", nullable=true)
     * @Groups("search:read")
     * @Groups("infos_mandat")
     */
    private $poids;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("search:read")
     * @Groups("infos_mandat")
     */
    private $couleurYeux;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("search:read")
     * @Groups("infos_mandat")
     */
    private $couleurPeau;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("search:read")
     * @Groups("infos_mandat")
     */
    private $couleurCheveux;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("search:read")
     * @Groups("infos_mandat")
     */
    private $photoName;

    /**
     * @var integer
     * 
     * @ORM\Column(type="integer", nullable=true)
     * @Groups("search:read")
     * @Groups("infos_mandat")
     */
    private $photoSize;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("search:read")
     * @Groups("infos_mandat")
     */
    private $sexe;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=255, nullable=true, name="numero_telephone")
     * @Groups("search:read")
     * @Groups("infos_mandat")
     */
    private $numeroTelephone;

    /**
     * @var string
     * 
     * @ORM\Column(type="text", nullable=true)
     * @Groups("search:read")
     * @Groups("infos_mandat")
     */
    private $observations;

    /**
     * @var Collection|Mandat[]
     * 
     * @ORM\OneToMany(targetEntity="App\Entity\Mandat", mappedBy="fugitif", orphanRemoval=true, cascade={"persist"})
     * @Groups("search:read")
     */
    private $mandats;

    /**
     * @var Collection|NationaliteFugitif[]
     * 
     * @ORM\OneToMany(targetEntity="App\Entity\NationaliteFugitif", mappedBy="fugitif", orphanRemoval=true, cascade={"persist"})
     * @Groups("search:read")
     * @Groups("infos_mandat")
     */
    private $listeNationalites;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("infos_mandat")
     * @Groups("search:read")
     */
    private $langues;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PieceIdentification", mappedBy="fugitif")
     * @Groups("infos_mandat")
     * @Groups("search:read")
     */
    private $pieceIdentification;

    public function __construct()
    {
        $this->listeNationalites = new ArrayCollection();
        $this->fugNationalites = new ArrayCollection();
        $this->mandats = new ArrayCollection();
        $this->pieceIdentification = new ArrayCollection();
    }

    /**
     * @return integer|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     * 
     * @return self
     */
    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPrenoms(): ?string
    {
        return $this->prenoms;
    }

    /**
     * @param string $prenoms
     * 
     * @return self
     */
    public function setPrenoms(string $prenoms): self
    {
        $this->prenoms = $prenoms;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNomMarital(): ?string
    {
        return $this->nomMarital;
    }

    /**
     * @param string|null $nomMarital
     * 
     * @return self
     */
    public function setNomMarital(?string $nomMarital): self
    {
        $this->nomMarital = $nomMarital;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAlias(): ?string
    {
        return $this->alias;
    }

    /**
     * @param string|null $alias
     * 
     * @return self
     */
    public function setAlias(?string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSurnom(): ?string
    {
        return $this->surnom;
    }

    /**
     * @param string|null $surnom
     * 
     * @return self
     */
    public function setSurnom(?string $surnom): self
    {
        $this->surnom = $surnom;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    /**
     * @param \DateTimeInterface|null $dateNaissance
     * 
     * @return self
     */
    public function setDateNaissance(?\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLieuNaissance(): ?string
    {
        return $this->lieuNaissance;
    }

    /**
     * @param string|null $lieuNaissance
     * 
     * @return self
     */
    public function setLieuNaissance(?string $lieuNaissance): self
    {
        $this->lieuNaissance = $lieuNaissance;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    /**
     * @param string|null $adresse
     * 
     * @return self
     */
    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getTaille(): ?float
    {
        return $this->taille;
    }

    /**
     * @param float|null $taille
     * 
     * @return self
     */
    public function setTaille(?float $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getPoids(): ?float
    {
        return $this->poids;
    }

    /**
     * @param float|null $poids
     * 
     * @return self
     */
    public function setPoids(?float $poids): self
    {
        $this->poids = $poids;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCouleurYeux(): ?string
    {
        return $this->couleurYeux;
    }

    /**
     * @param string|null $couleurYeux
     * 
     * @return self
     */
    public function setCouleurYeux(?string $couleurYeux): self
    {
        $this->couleurYeux = $couleurYeux;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCouleurPeau(): ?string
    {
        return $this->couleurPeau;
    }

    /**
     * @param string|null $couleurPeau
     * 
     * @return self
     */
    public function setCouleurPeau(?string $couleurPeau): self
    {
        $this->couleurPeau = $couleurPeau;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCouleurCheveux(): ?string
    {
        return $this->couleurCheveux;
    }

    /**
     * @param string|null $couleurCheveux
     * 
     * @return self
     */
    public function setCouleurCheveux(?string $couleurCheveux): self
    {
        $this->couleurCheveux = $couleurCheveux;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhotoName(): ?string
    {
        return $this->photoName;
    }

    /**
     * @param string|null $photoName
     * 
     * @return self
     */
    public function setPhotoName(?string $photoName): self
    {
        $this->photoName = $photoName;

        return $this;
    }

    /**
     * @return integer|null
     */
    public function getPhotoSize(): ?int
    {
        return $this->photoSize;
    }

    /**
     * @param integer|null $photoSize
     * 
     * @return self
     */
    public function setPhotoSize(?int $photoSize): self
    {
        $this->photoSize = $photoSize;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    /**
     * @param string|null $sexe
     * 
     * @return self
     */
    public function setSexe(?string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNumeroTelephone(): ?string
    {
        return $this->numeroTelephone;
    }

    /**
     * @param string|null $numeroTelephone
     * 
     * @return self
     */
    public function setNumeroTelephone(?string $numeroTelephone): self
    {
        $this->numeroTelephone = $numeroTelephone;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getObservations(): ?string
    {
        return $this->observations;
    }

    /**
     * @param string|null $observations
     * 
     * @return self
     */
    public function setObservations(?string $observations): self
    {
        $this->observations = $observations;

        return $this;
    }

    /**
     * @return Collection|Mandat[]
     */
    public function getMandats(): Collection
    {
        return $this->mandats;
    }

    /**
     * @param Mandat $mandat
     * 
     * @return self
     */
    public function addMandat(Mandat $mandat): self
    {
        if (!$this->mandats->contains($mandat)) {
            $this->mandats[] = $mandat;
            $mandat->setFugitif($this);
        }

        return $this;
    }

    /**
     * @param Mandat $mandat
     * 
     * @return self
     */
    public function removeMandat(Mandat $mandat): self
    {
        if ($this->mandats->contains($mandat)) {
            $this->mandats->removeElement($mandat);
            // set the owning side to null (unless already changed)
            if ($mandat->getFugitif() === $this) {
                $mandat->setFugitif(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|NationaliteFugitif[]
     */
    public function getListeNationalites(): Collection
    {
        return $this->listeNationalites;
    }

    /**
     * @param NationaliteFugitif $listeNationalite
     * 
     * @return self
     */
    public function addListeNationalite(NationaliteFugitif $listeNationalite): self
    {
        if (!$this->listeNationalites->contains($listeNationalite)) {
            $this->listeNationalites[] = $listeNationalite;
            $listeNationalite->setFugitif($this);
        }

        return $this;
    }

    /**
     * @param NationaliteFugitif $listeNationalite
     * 
     * @return self
     */
    public function removeListeNationalite(NationaliteFugitif $listeNationalite): self
    {
        if ($this->listeNationalites->contains($listeNationalite)) {
            $this->listeNationalites->removeElement($listeNationalite);
            // set the owning side to null (unless already changed)
            if ($listeNationalite->getFugitif() === $this) {
                $listeNationalite->setFugitif(null);
            }
        }

        return $this;
    }

    public function getLangues(): ?string
    {
        return $this->langues;
    }

    public function setLangues(?string $langues): self
    {
        $this->langues = $langues;

        return $this;
    }

    /**
     * @return Collection|PieceIdentification[]
     */
    public function getPieceIdentification(): Collection
    {
        return $this->pieceIdentification;
    }

    public function addPieceIdentification(PieceIdentification $pieceIdentification): self
    {
        if (!$this->pieceIdentification->contains($pieceIdentification)) {
            $this->pieceIdentification[] = $pieceIdentification;
            $pieceIdentification->setFugitif($this);
        }

        return $this;
    }

    public function removePieceIdentification(PieceIdentification $pieceIdentification): self
    {
        if ($this->pieceIdentification->contains($pieceIdentification)) {
            $this->pieceIdentification->removeElement($pieceIdentification);
            // set the owning side to null (unless already changed)
            if ($pieceIdentification->getFugitif() === $this) {
                $pieceIdentification->setFugitif(null);
            }
        }

        return $this;
    }

    /**
     * @var Fugitif The fugitif object from which values are gonna be copied
     * 
     * @return Fugitif
     */
    public function copy(Fugitif $fugitif){
        $this->nom = $fugitif->getNom();
        $this->prenoms = $fugitif->getPrenoms();
        $this->alias = $fugitif->getAlias();
        $this->dateNaissance = $fugitif->getDateNaissance();
        $this->lieuNaissance = $fugitif->getLieuNaissance();
        $this->nomMarital = $fugitif->getNomMarital();
        $this->couleurCheveux = $fugitif->getCouleurCheveux();
        $this->couleurPeau = $fugitif->getCouleurPeau();
        $this->couleurYeux = $fugitif->getCouleurYeux();
        $this->langues = $fugitif->getLangues();
        $this->sexe = $fugitif->getSexe();
        $this->adresse = $fugitif->getAdresse();
        $this->taille = $fugitif->getTaille();
        $this->poids = $fugitif->getPoids();
        $this->nom = $fugitif->getNom();
        $this->numeroTelephone = $fugitif->getNumeroTelephone();
        $this->observations = $fugitif->getObservations();
        $this->mandats = $fugitif->getMandats();
        $this->listeNationalites = $fugitif->getListeNationalites();
    }
}
