<?php

namespace App\Entity;

use App\Repository\PersoDispoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PersoDispoRepository::class)
 */
class PersoDispo
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
    private $univers_id;

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
    private $roliste_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUniversId(): ?int
    {
        return $this->univers_id;
    }

    public function setUniversId(int $univers_id): self
    {
        $this->univers_id = $univers_id;

        return $this;
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

    public function getRolisteId(): ?int
    {
        return $this->roliste_id;
    }

    public function setRolisteId(int $roliste_id): self
    {
        $this->roliste_id = $roliste_id;

        return $this;
    }
}
