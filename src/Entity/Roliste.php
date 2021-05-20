<?php

namespace App\Entity;

use App\Repository\RolisteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RolisteRepository::class)
 */
class Roliste
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $personnage_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $communaute_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $user_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPersonnageId(): ?int
    {
        return $this->personnage_id;
    }

    public function setPersonnageId(int $personnage_id): self
    {
        $this->personnage_id = $personnage_id;

        return $this;
    }

    public function getCommunauteId(): ?int
    {
        return $this->communaute_id;
    }

    public function setCommunauteId(int $communaute_id): self
    {
        $this->communaute_id = $communaute_id;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }
}
