<?php

namespace App\Entity;

use App\Repository\OfferRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;
use App\Entity\Game;
use App\Entity\Category;

/**
 * @ORM\Entity(repositoryClass=OfferRepository::class)
 */
class Offer
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
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $picture;

    /**
     * @ORM\Column(type="datetime")
     */
    private $publication_date;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $selling_price;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rent_price;

    /**
     * @ORM\Column(type="integer")
     */
    private $statement;

    /**
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="offers")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=game::class, inversedBy="offers")
     */
    private $game;

    /**
     * @ORM\ManyToOne(targetEntity=category::class, inversedBy="offers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getPublicationDate(): ?\DateTimeInterface
    {
        return $this->publication_date;
    }

    public function setPublicationDate(\DateTimeInterface $publication_date): self
    {
        $this->publication_date = $publication_date;

        return $this;
    }

    public function getSellingPrice(): ?int
    {
        return $this->selling_price;
    }

    public function setSellingPrice(?int $selling_price): self
    {
        $this->selling_price = $selling_price;

        return $this;
    }

    public function getRentPrice(): ?int
    {
        return $this->rent_price;
    }

    public function setRentPrice(?int $rent_price): self
    {
        $this->rent_price = $rent_price;

        return $this;
    }

    public function getStatement(): ?int
    {
        return $this->statement;
    }

    public function setStatement(int $statement): self
    {
        $this->statement = $statement;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): self
    {
        $this->game = $game;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
