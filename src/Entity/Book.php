<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ApiResource(
    description: 'Représente un livre dans la bibliothèque',
    operations: [
        // admin
        new GetCollection(uriTemplate: '/admin/books'),
        // library
        new GetCollection(uriTemplate: '/library/books'),
        new Post(uriTemplate: '/library/books'),
        new Get(uriTemplate: '/library/books/{id}'),
        new Patch(uriTemplate: '/library/books/{id}'),
        new Delete(uriTemplate: '/library/books/{id}')
    ],
    normalizationContext: ['groups' => ['book:read']],
    denormalizationContext: ['groups' => ['book:write']]
)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    #[Groups(['book:read'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 255)]
    #[Groups(['book:read', 'book:write'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Groups(['book:read', 'book:write'])]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['book:read'])]
    private \DateTimeInterface $publishedAt;

    public function __construct()
    {
        $this->publishedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Book
    {
        $this->id = $id;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): Book
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): Book
    {
        $this->description = $description;
        return $this;
    }

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->publishedAt;
    }
}

