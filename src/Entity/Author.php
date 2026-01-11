<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    normalizationContext: ['groups' => ['author:read']],
    denormalizationContext: ['groups' => ['author:write']]
)]
#[ORM\Entity]
class Author
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['author:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['author:read', 'author:write', 'book:read'])]
    private string $name;

    #[ORM\OneToMany(targetEntity: Book::class, mappedBy: 'author')]
    #[Groups(['author:read'])]
    private Collection $books;

    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Author
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Author
    {
        $this->name = $name;
        return $this;
    }

    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): void
    {
        $this->books->add($book);
        $book->setAuthor($this);
    }

    public function removeBook(Book $book): void
    {
        $this->books->removeElement($book);
        $book->setAuthor(null);
    }
}
