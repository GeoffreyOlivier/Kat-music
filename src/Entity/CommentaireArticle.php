<?php

namespace App\Entity;

use App\Repository\CommentaireArticleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentaireArticleRepository::class)
 */
class CommentaireArticle
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=55)
     */
    private $Pseudo;

    /**
     * @ORM\Column(type="datetime")
     */
    private $CreatedAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Content;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Valide;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Email;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="commentaireArticles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Article;
    /**
     * CommentaireArticle constructor.
     * @param $CreatedAt
     * @throws \Exception
     */

    // public function __construct($CreatedAt)
    // {
    //     $this->CreatedAt =  new \DateTime('now');
    // }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->Pseudo;
    }

    public function setPseudo(string $Pseudo): self
    {
        $this->Pseudo = $Pseudo;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(\DateTimeInterface $CreatedAt): self
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->Content;
    }

    public function setContent(string $Content): self
    {
        $this->Content = $Content;

        return $this;
    }

    public function getValide(): ?bool
    {
        return $this->Valide;
    }

    public function setValide(bool $Valide): self
    {
        $this->Valide = $Valide;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getArticcle(): ?Article
    {
        return $this->Articcle;
    }

    public function setArticcle(?Article $Articcle): self
    {
        $this->Articcle = $Articcle;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->Article;
    }

    public function setArticle(?Article $Article): self
    {
        $this->Article = $Article;

        return $this;
    }
}
