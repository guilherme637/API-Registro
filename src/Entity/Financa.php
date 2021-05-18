<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Financa implements \JsonSerializable
{
    private int $id;
    private float $saldo;
    private \DateTimeInterface $data;
    private float $dispesa;
    private $conta;

    public function __construct()
    {
        $this->conta = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSaldo(): float
    {
        return $this->saldo;
    }

    public function setSaldo(float $saldo): void
    {
        $this->saldo = $saldo;
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
            $contum->setFinanca($this);
        }

        return $this;
    }

    public function removeContum(Conta $contum): self
    {
        if ($this->conta->removeElement($contum)) {
            // set the owning side to null (unless already changed)
            if ($contum->getFinanca() === $this) {
                $contum->setFinanca(null);
            }
        }

        return $this;
    }

    public function getData(): \DateTimeInterface
    {
        return $this->data;
    }

    public function setData(\DateTimeInterface $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'saldo' => $this->getSaldo(),
            'mes' => $this->getData()->format('d-m-Y'),
        ];
    }
}