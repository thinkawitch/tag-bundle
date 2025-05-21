<?php

namespace Thinkawitch\TagBundle\Entity;

use Thinkawitch\TagBundle\Repository\TagRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagRepository::class)]
#[ORM\Table(name: 'thinkawitch_tag')]
#[ORM\UniqueConstraint(name: 'name_category', columns: ['name', 'category'])]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 200)]
    private string $name;

    #[ORM\Column(length: 200, options: ['default' => 'default'])]
    private string $category = 'default';

    public function getId(): ?int
    {
        return $this->id ?? null; // just created and not saved
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;
        return $this;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}