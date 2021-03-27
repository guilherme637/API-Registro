<?php

namespace App\Entity;

use App\Repository\GrupoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass=GrupoRepository::class)
 */
class Grupo implements JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=120)
     */
    private $tipo;

    /**
     * @ORM\OneToMany(targetEntity=Conta::class, mappedBy="grupo")
     */
    private $conta;

    public function __construct()
    {
        $this->conta = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * @return Collection|Conta[]
     */
    public function getConta(): Collection
    {
        return $this->conta;
    }

    public function addContum(Conta $contum): self
    {
        if (!$this->conta->contains($contum)) {
            $this->conta[] = $contum;
            $contum->setGrupo($this);
        }

        return $this;
    }

    public function removeContum(Conta $contum): self
    {
        if ($this->conta->removeElement($contum)) {
            // set the owning side to null (unless already changed)
            if ($contum->getGrupo() === $this) {
                $contum->setGrupo(null);
            }
        }

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'grupo' => ucfirst($this->getTipo())
        ];
    }
}
