<?php

namespace App\Entity;

use DateTimeInterface;
use JsonSerializable;

class Conta implements JsonSerializable
{
    private int $id;
    private string $nome;
    private float $valor;
    private DateTimeInterface $data;
    private string $dataFeedBack;
    private Grupo $grupo;
    private Financa $financa;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getValor(): ?float
    {
        return $this->valor;
    }

    public function setValor(float $valor): self
    {
        $this->valor = $valor;

        return $this;
    }

    public function getData(): ?DateTimeInterface
    {
        return $this->data;
    }

    public function setData(DateTimeInterface $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getGrupo(): ?Grupo
    {
        return $this->grupo;
    }

    public function setGrupo(Grupo $grupo): self
    {
        $this->grupo = $grupo;

        return $this;
    }


    public function getDataFeedBack(): ?string
    {
        return $this->dataFeedBack;
    }

    public function setDataFeedBack(?string $dataFeedBack): self
    {
        $this->dataFeedBack = $dataFeedBack;

        return $this;
    }

    public function getFinanca(): Financa
    {
        return $this->financa;
    }

    public function setFinanca(Financa $financa): self
    {
        $this->financa = $financa;

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'nome' => $this->getNome(),
            'valor' => $this->getValor(),
            'vencimento' => $this->getData()->format('m-d-Y'),
            'feedback' => $this->getDataFeedBack(),
            'tipoConta' => $this->getGrupo(),
            'financa' => $this->getFinanca()
        ];
    }
}
