<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Table.php';


class ScoreTableRepository extends Repository {

    public function getScoreTable(int $league_id): array{
        $result = [];

        $stmt = $this->database->connect()->prepare('
            select t.name, s.points, s.games, s.wins, s.loses, s.draws, s."goalplus", s."goalminus", s."goalplusminus", l.name,l.leauge_id
            from score_table s join teams t on s.druzyna = t."team_ID" join leagues l
            on l.leauge_id = t."league_ID" where l.leauge_id=:id order by points desc
        ');
        $stmt-> bindParam(':id',$league_id, PDO::PARAM_INT);
        $stmt->execute();
        $score_table = $stmt->fetchAll(PDO::FETCH_NAMED);

        foreach ($score_table as $table) {
            $result[] = new Table(
                $table['name'][0],
                $table['points'],
                $table['games'],
                $table['wins'],
                $table['loses'],
                $table['draws'],
                $table['goalplus'],
                $table['goalminus'],
                $table['goalplusminus'],
                $table['name'][1],
                $table['leauge_id']
            );
        }
        return $result;
    }
}