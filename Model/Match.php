<?php

namespace Model;

class Match
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var Team
     */
    protected $team1;

    /**
     * @var Team
     */
    protected $team2;

    /**
     * @boolean bool
     */
    protected $matchIsFinished;

    /**
     * @var Result
     */
    protected $halfTimeResult;

    /**
     * @var Result
     */
    protected $endResult;

    /**
     * @var \DateTime
     */
    protected $matchDateTime;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTeam1(): Team
    {
        return $this->team1;
    }

    public function setTeam1(Team $team1): self
    {
        $this->team1 = $team1;
        return $this;
    }

    public function getTeam2(): Team
    {
        return $this->team2;
    }

    public function setTeam2(Team $team2): self
    {
        $this->team2 = $team2;
        return $this;
    }

    public function getMatchIsFinished(): bool
    {
        return $this->matchIsFinished;
    }

    public function setMatchIsFinished(bool $matchIsFinished): self
    {
        $this->matchIsFinished = $matchIsFinished;
        return $this;
    }

    public function getHalfTimeResult(): Result
    {
        return $this->halfTimeResult;
    }

    public function setHalfTimeResult(Result $halfTimeResult): self
    {
        $this->halfTimeResult = $halfTimeResult;
        return $this;
    }

    public function getEndResult(): Result
    {
        return $this->endResult;
    }

    public function setEndResult(Result $endResult): self
    {
        $this->endResult = $endResult;
        return $this;
    }

    public function getMatchDateTime(): \DateTime
    {
        return $this->matchDateTime;
    }

    public function setMatchDateTime(\DateTime $matchDateTime): self
    {
        $this->matchDateTime = $matchDateTime;
        return $this;
    }
}