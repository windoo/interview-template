<?php

namespace App\Entity;

use App\Repository\IdeaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=IdeaRepository::class)
 */
class Idea
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
    private $proposal;

    /**
     * @ORM\Column(type="datetime")
     */
    private $create_at;

    // /**
    //  * @ORM\Column(type="boolean", nullable=true)
    //  */
    // private $inFavor;

    // /**
    //  * @ORM\Column(type="boolean", nullable=true)
    //  */
    // private $against;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="vote")
     */
    private $userVote;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="ideas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $suggester;

    /**
     * @ORM\Column(type="integer")
     */
    private $inFavor;

    /**
     * @ORM\Column(type="integer")
     */
    private $against;

    public function __construct()
    {
        $this->userVote = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProposal(): ?string
    {
        return $this->proposal;
    }

    public function setProposal(string $proposal): self
    {
        $this->proposal = $proposal;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->create_at;
    }

    public function setCreateAt(\DateTimeInterface $create_at): self
    {
        $this->create_at = $create_at;

        return $this;
    }

    // public function getInFavor(): ?bool
    // {
    //     return $this->inFavor;
    // }

    // public function setInFavor(?bool $inFavor): self
    // {
    //     $this->inFavor = $inFavor;

    //     return $this;
    // }

    // public function getAgainst(): ?bool
    // {
    //     return $this->against;
    // }

    // public function setAgainst(?bool $against): self
    // {
    //     $this->against = $against;

    //     return $this;
    // }

    /**
     * @return Collection|User[]
     */
    public function getUserVote(): Collection
    {
        return $this->userVote;
    }

    public function addUserVote(User $userVote): self
    {
        if (!$this->userVote->contains($userVote)) {
            $this->userVote[] = $userVote;
            $userVote->addVote($this);
        }

        return $this;
    }

    public function removeUserVote(User $userVote): self
    {
        if ($this->userVote->removeElement($userVote)) {
            $userVote->removeVote($this);
        }

        return $this;
    }

    public function getSuggester(): ?User
    {
        return $this->suggester;
    }

    public function setSuggester(?User $suggester): self
    {
        $this->suggester = $suggester;

        return $this;
    }

    public function getInFavor(): ?int
    {
        return $this->inFavor;
    }

    public function setInFavor(int $inFavor): self
    {
        $this->inFavor = $inFavor;

        return $this;
    }

    public function getAgainst(): ?int
    {
        return $this->against;
    }

    public function setAgainst(int $against): self
    {
        $this->against = $against;

        return $this;
    }
}
