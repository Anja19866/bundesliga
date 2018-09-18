<?php
/**
 * Created by PhpStorm.
 * User: anja
 * Date: 20.08.18
 * Time: 10:15
 */

namespace Model;

class Match
{
    /**
     * @var string
     */
    protected $team1;

    /**
     * @var string
     */
    protected $team2;

    /**
     * @var string
     */
    protected $team1Icon;

    /**
     * @var string
     */
    protected $team2Icon;

    /**
     * @var boolean
     */
    protected $matchIsFinished;

    /**
     * @var integer
     */
    protected $resultTeam1Half1;

    /**
     * @var integer
     */
    protected $resultTeam2Half1;

    /**
     * @var integer
     */
    protected $resultTeam1End;

    /**
     * @var integer
     */
    protected $resultTeam2End;

    /**
     * ToDo: \DateTime
     * @var string
     */
    protected $matchDateTime;

    public function getTeam1(): string
    {
        return $this->team1;
    }

    public function setTeam1(string $team1): self
    {
        $this->team1 = $team1;
        return $this;
    }

    public function getTeam2(): string
    {
        return $this->team2;
    }

    public function setTeam2(string $team2): self
    {
        $this->team2 = $team2;
        return $this;
    }

    public function getTeam1Icon(): string
    {
        return $this->team1Icon;
    }

    public function setTeam1Icon(string $team1Icon): self
    {
        $this->team1Icon = $team1Icon;
        return $this;
    }

    public function getTeam2Icon(): string
    {
        return $this->team2Icon;
    }

    public function setTeam2Icon(string $team2Icon): self
    {
        $this->team2Icon = $team2Icon;
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

    public function getResultTeam1Half1(): int
    {
        return $this->resultTeam1Half1;
    }

    public function setResultTeam1Half1(int $resultTeam1Half1): self
    {
        $this->resultTeam1Half1 = $resultTeam1Half1;
        return $this;
    }

    public function getResultTeam2Half1(): int
    {
        return $this->resultTeam2Half1;
    }

    public function setResultTeam2Half1(int $resultTeam2Half1): self
    {
        $this->resultTeam2Half1 = $resultTeam2Half1;
        return $this;
    }

    public function getResultTeam1End(): int
    {
        return $this->resultTeam1End;
    }

    public function setResultTeam1End(int $resultTeam1End): self
    {
        $this->resultTeam1End = $resultTeam1End;
        return $this;
    }

    public function getResultTeam2End(): int
    {
        return $this->resultTeam2End;
    }

    public function setResultTeam2End(int $resultTeam2End): self
    {
        $this->resultTeam2End = $resultTeam2End;
        return $this;
    }

    public function getMatchDateTime(): string
    {
        return $this->matchDateTime;
    }

    public function setMatchDateTime(string $matchDateTime): self
    {
        $this->matchDateTime = $matchDateTime;
        return $this;
    }
}