<?php

class Table{
    private $name;
    private $points;
    private $games;
    private $wins;
    private $loses;
    private $draws;
    private $goalplus;
    private $goalminus;
    private $goalplusminus;
    private $leauge_name;
    private $leauge_id;

    public function __construct(string $team_name,
                                int $points,
                                int $games,
                                int $wins,
                                int $loses,
                                int $draws,
                                int $goal_plus,
                                int $goal_minus,
                                int $goal_plus_minus,
                                string $leauge_name,
                                int $league_id
    )
    {
        $this->name = $team_name;
        $this->points = $points;
        $this->games = $games;
        $this->wins = $wins;
        $this->loses = $loses;
        $this->draws = $draws;
        $this->goalplus = $goal_plus;
        $this->goalminus = $goal_minus;
        $this->goalplusminus = $goal_plus_minus;
        $this->leauge_name = $leauge_name;
        $this->leauge_id = $league_id;
    }


    public function getLeaugeId()
    {
        return $this->leauge_id;
    }

    public function setLeaugeId($leauge_id): void
    {
        $this->leauge_id = $leauge_id;
    }

    public function getLeaugeName()
    {
        return $this->leauge_name;
    }

    public function setLeaugeName($leauge_name): void
    {
        $this->leauge_name = $leauge_name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getPoints()
    {
        return $this->points;
    }

    public function setPoints($points): void
    {
        $this->points = $points;
    }

    public function getGames()
    {
        return $this->games;
    }

    public function setGames($games): void
    {
        $this->games = $games;
    }

    public function getWins()
    {
        return $this->wins;
    }

    public function setWins($wins): void
    {
        $this->wins = $wins;
    }

    public function getLoses()
    {
        return $this->loses;
    }

    public function setLoses($loses): void
    {
        $this->loses = $loses;
    }

    public function getDraws()
    {
        return $this->draws;
    }

    public function setDraws($draws): void
    {
        $this->draws = $draws;
    }

    public function getGoalplus()
    {
        return $this->goalplus;
    }

    public function setGoalplus($goalplus): void
    {
        $this->goalplus = $goalplus;
    }

    public function getGoalminus()
    {
        return $this->goalminus;
    }

    public function setGoalminus($goalminus): void
    {
        $this->goalminus = $goalminus;
    }
     function getGoalplusminus()
    {
        return $this->goalplusminus;
    }

    public function setGoalplusminus($goalplusminus): void
    {
        $this->goalplusminus = $goalplusminus;
    }



}