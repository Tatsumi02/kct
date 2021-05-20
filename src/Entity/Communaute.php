<?php

namespace App\Entity;

use App\Repository\CommunauteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommunauteRepository::class)
 */
class Communaute
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="integer")
     */
    private $univers_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $createur_id;

    /**
     * @ORM\Column(type="text")
     */
    private $reglement;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_creation;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $etat;

    // /**
    //  * @ORM\Column(type="string", length=255)
    //  */
    // private $element;

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

    public function getUniversId(): ?int
    {
        return $this->univers_id;
    }

    public function setUniversId(int $univers_id): self
    {
        $this->univers_id = $univers_id;

        return $this;
    }

    public function getCreateurId(): ?int
    {
        return $this->createur_id;
    }

    public function setCreateurId(int $createur_id): self
    {
        $this->createur_id = $createur_id;

        return $this;
    }

    public function getReglement(): ?string
    {
        return $this->reglement;
    }

    public function setReglement(string $reglement): self
    {
        $this->reglement = $reglement;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTimeInterface $date_creation): self
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    // public function getElement(): ?string
    // {
    //     return $this->element;
    // }

    // public function setElement(string $element): self
    // {
    //     $this->element = $element;

    //     return $this;
    // }
}
