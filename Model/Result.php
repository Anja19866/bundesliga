<?php

namespace Model;

class Result
{
    /**
     * @var integer|null
     */
    protected $pointsTeam1;

    /**
     * @var integer|null
     */
    protected $pointsTeam2;

    public function getPointsTeam1(): ?int
    {
        return $this->pointsTeam1;
    }

    public function setPointsTeam1(?int $pointsTeam1): self
    {
        $this->pointsTeam1 = $pointsTeam1;
        return $this;
    }

    public function getPointsTeam2(): ?int
    {
        return $this->pointsTeam2;
    }

    public function setPointsTeam2(?int $pointsTeam2): self
    {
        $this->pointsTeam2 = $pointsTeam2;
        return $this;
    }
}
