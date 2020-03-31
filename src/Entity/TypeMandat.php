<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeMandatRepository")
 * @ORM\Table(schema="metier")
 * @ORM\HasLifecycleCallbacks()
 */
class TypeMandat
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
}
