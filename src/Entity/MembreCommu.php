<?php

namespace App\Entity;

use App\Repository\MembreCommuRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MembreCommuRepository::class)
 */
class MembreCommu
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
    private $commu_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $membre_id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_ajout;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $etat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommuId(): ?int
    {
        return $this->commu_id;
    }

    public function setCommuId(int $commu_id): self
    {
        $this->commu_id = $commu_id;

        return $this;
    }

    public function getMembreId(): ?int
    {
        return $this->membre_id;
    }

    public function setMembreId(int $membre_id): self
    {
        $this->membre_id = $membre_id;

        return $this;
    }

    public function getDateAjout(): ?\DateTimeInterface
    {
        return $this->date_ajout;
    }

    public function setDateAjout(\DateTimeInterface $date_ajout): self
    {
        $this->date_ajout = $date_ajout;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }
}
