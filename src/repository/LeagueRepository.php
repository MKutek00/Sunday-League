<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/League.php';


class LeagueRepository extends Repository {

    public function getLeagues(): array{
        $result = [];

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM leagues;
        ');
        $stmt->execute();
        $leagues = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($leagues as $league){
            $result[] = new League(
                $league['name'],
                $league['leauge_id']
            );
        }
        return $result;
    }

}