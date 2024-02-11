<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Post(),
        new GetCollection()
    ]
)]
#[ORM\Entity]
class Author
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    private ?string $name = null;

    #[ORM\Column(length: 60)]
    #[Assert\Length(min: 2)]
    private ?string $surname = null;

    #[ORM\Column(length: 60, nullable: true)]
    private ?string $patronimyc = null;

    #[ORM\ManyToOne(targetEntity: Book::class, inversedBy: 'authors')]
    private ?Book $book = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(?string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getPatronimyc(): ?string
    {
        return $this->patronimyc;
    }

    public function setPatronimyc(?string $patronimyc): void
    {
        $this->patronimyc = $patronimyc;
    }

    public function getBook(): ?Book {
        return $this->book;
    }

    public function setBook(?Book $book): self
    {
        $this->book = $book;

        return $this;
    }
}