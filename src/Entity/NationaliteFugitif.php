<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NationaliteFugitifRepository")
 * @ORM\Table(schema="metier")
 * @ORM\HasLifecycleCallbacks()
 */
class NationaliteFugitif
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Nationalite", inversedBy="natFugitifs", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups("search:read")
     * @Groups("infos_mandat")
     */
    private $nationalite;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Fugitif", inversedBy="listeNationalites", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @MaxDepth(1)
     */
    private $fugitif;

    /**
     * @ORM\Column(type="boolean")
     * @Groups("search:read")
     */
    private $principale = true;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNationalite(): ?Nationalite
    {
        return $this->nationalite;
    }

    public function setNationalite(?Nationalite $nationalite): self
    {
        $this->nationalite = $nationalite;

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

    public function getPrincipale(): ?bool
    {
        return $this->principale;
    }

    public function setPrincipale(bool $principale): self
    {
        $this->principale = $principale;

        return $this;
    }
}
