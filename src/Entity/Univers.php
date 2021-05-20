<?php

namespace App\Entity;

use App\Repository\UniversRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UniversRepository::class)
 */
class Univers
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
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photo_couverture;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lien_ref;

    /**
     * @ORM\Column(type="integer")
     */
    private $createur_id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_creation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $etat;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPhotoCouverture(): ?string
    {
        return $this->photo_couverture;
    }

    public function setPhotoCouverture(string $photo_couverture): self
    {
        $this->photo_couverture = $photo_couverture;

        return $this;
    }

    public function getLienRef(): ?string
    {
        return $this->lien_ref;
    }

    public function setLienRef(string $lien_ref): self
    {
        $this->lien_ref = $lien_ref;

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

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTimeInterface $date_creation): self
    {
        $this->date_creation = $date_creation;

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
