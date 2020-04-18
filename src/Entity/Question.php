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
     * @ORM\OneToMany(targetEntity="App\Entity\UserQuestion", mappedBy="question", orphanRemoval=true)
     */
    private $userQuestions;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    private static $POINTSPERCORRECT = 10;
    private static $POINTSPERDONTKNOW = -1;
    private static $POINTSPERWRONG = -10;

    public function __construct()
    {
        $this->answer = new ArrayCollection();
        $this->userQuestions = new ArrayCollection();
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
     * @return Collection|UserQuestion[]
     */
    public function getUserQuestions(): Collection
    {
        return $this->userQuestions;
    }

    public function addUserQuestion(UserQuestion $userQuestion): self
    {
        if (!$this->userQuestions->contains($userQuestion)) {
            $this->userQuestions[] = $userQuestion;
            $userQuestion->setQuestion($this);
        }

        return $this;
    }

    public function removeUserQuestion(UserQuestion $userQuestion): self
    {
        if ($this->userQuestions->contains($userQuestion)) {
            $this->userQuestions->removeElement($userQuestion);
            // set the owning side to null (unless already changed)
            if ($userQuestion->getQuestion() === $this) {
                $userQuestion->setQuestion(null);
            }
        }

        return $this;
    }

    public function AnswerCheck($user, $team, $question, $points, $iscorrect): UserQuestion {
        $user->setScore($user->getScore() + $points);
        $team->setTeamScore($team->getTeamScore() + $points);
        return new UserQuestion($user, $question, $iscorrect);
    }


    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return int
     */
    public static function getPOINTSPERCORRECT(): int
    {
        return self::$POINTSPERCORRECT;
    }

    /**
     * @return int
     */
    public static function getPOINTSPERDONTKNOW(): int
    {
        return self::$POINTSPERDONTKNOW;
    }

    /**
     * @return int
     */
    public static function getPOINTSPERWRONG(): int
    {
        return self::$POINTSPERWRONG;
    }




}
