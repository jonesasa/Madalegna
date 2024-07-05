<?php

namespace App\Entity;

use App\Repository\TabsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TabsRepository::class)]
class Tabs
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $fotos = null;

    #[ORM\Column(length: 255)]
    private ?string $texto = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFotos(): ?string
    {
        return $this->fotos;
    }

    public function setFotos(string $fotos): static
    {
        $this->fotos = $fotos;

        return $this;
    }

    public function getTexto(): ?string
    {
        return $this->texto;
    }

    public function setTexto(string $texto): static
    {
        $this->texto = $texto;

        return $this;
    }
}
