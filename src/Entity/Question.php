<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionRepository")
 */
class Question
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $question;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Answer", mappedBy="question", cascade={"persist"}, orphanRemoval=true)
     */
    private $answer;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="WrongQuestion")
     */
    private $wronguser;

    public function __construct()
    {
        $this->answer = new ArrayCollection();
        $this->wronguser = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Answer[]
     */
    public function getAnswer(): Collection
    {
        return $this->answer;
    }

    public function addAnswer(Answer $answer): self
    {
        if (!$this->answer->contains($answer)) {
            $this->answer[] = $answer;
            $answer->setQuestion($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->answer->contains($answer)) {
            $this->answer->removeElement($answer);
            // set the owning side to null (unless already changed)
            if ($answer->getQuestion() === $this) {
                $answer->setQuestion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUser(): Collection
    {
        return $this->wronguser;
    }

    public function addUser(User $user): self
    {
        if (!$this->wronguser->contains($user)) {
            $this->wronguser[] = $user;
            $user->addWrongQuestion($this);
        }

        return $this;
    }

    public function removeWronguser(User $wronguser): self
    {
        if ($this->wronguser->contains($wronguser)) {
            $this->wronguser->removeElement($wronguser);
            $wronguser->removeWrongQuestion($this);
        }

        return $this;
    }

}
