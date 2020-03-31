<?php
/**
 * @author Tafsir GNA <tgna@presidence.bj>
 * @version 0.1
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

trait UserActionsTrait
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    protected $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    protected $updatedBy;

    /**
     * Get the object creator
     *
     * @return  User
     */ 
    public function getCreatedBy() : ? User
    {
        return $this->createdBy;
    }

    /**
     * Set the object creator
     *
     * @param  User
     *
     * @return  self
     */ 
    public function setCreatedBy(User $user) : self
    {
        $this->createdBy = $user;

        return $this;
    }

    /**
     * Get the last user which updated this object
     *
     * @return  User
     */ 
    public function getUpdatedBy() : ? User
    {
        return $this->updatedBy;
    }

    /**
     * Set the last user which updated this object
     *
     * @param  User
     *
     * @return  self
     */ 
    public function setUpdatedBy(User $user) : self
    {
        $this->updatedBy = $user;

        return $this;
    }

}