<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use App\Trait\CalculsTrait;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    use CalculsTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\Type('string')]
    #[Assert\NotBlank(message: 'not_blank')]
    #[Assert\Length(
        max: 50,
        maxMessage: 'article.name.length',
    )]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\Type('string')]
    #[Assert\NotBlank(message: 'not_blank')]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Assert\Type('numeric')]
    #[Assert\NotBlank(message: 'not_blank')]
    #[Assert\Positive(message: 'positive')]
    #[Assert\Regex(
        pattern: '/^\d+(\.\d{1,2})?$/',
        message: 'decimal_max_2'
    )]
    private ?string $priceHT = null;

    #[ORM\Column(length: 255)]
    #[Assert\Type('string')]
    private ?string $image = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPriceHT(): string
    {
        return $this->priceHT;
    }

    public function setPriceHT(string $priceHT): static
    {
        $this->priceHT = $priceHT;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getFullPathImage(): string
    {
        return 'uploads/articles/' . $this->getImage();
    }

    public function getPriceTTC(): float
    {
       return $this->calculateTTC($this->priceHT, 20);
    }
}
