<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Schedule.php';


class ScheduleRepository extends Repository {

    public function getSchedule(int $league_id): array{
        $result = [];

        $stmt = $this->database->connect()->prepare('select t1.name, t2.name, s.date, l.name,l.leauge_id, s."ID_schedule", s."roundNumber"
from schedule s
         left join teams t1
                   on s.team_one = t1."team_ID"
         left join teams t2
                   on s.team_two = t2."team_ID"
         join leagues l
              on l.leauge_id = t2."league_ID" where l.leauge_id=:id
            ');

        $stmt->bindParam(':id',$league_id, PDO::PARAM_INT);
        $stmt->execute();
        $schedule = $stmt->fetchAll(PDO::FETCH_NAMED);

        foreach ($schedule as $match){
            $result[] = new Schedule(
                $match['name'][0],
                $match['name'][1],
                $match['date'],
                $match['name'][2],
                '',
                $match['leauge_id'],
                $match['ID_schedule'],
                $match['roundNumber']
            );
        }
        return $result;
    }

    public function updateScore(int $teamOneGoals, int $teamTwoGoals, int $scheduleID){
        $stmt = $this->database->connect()->prepare('
            UPDATE schedule SET team_one_goals = :teamOneGoals,
                                team_two_goals = :teamTwoGoals
                    WHERE "ID_schedule" = :scheduleID
            ');
        $stmt->bindParam(':teamOneGoals', $teamOneGoals, PDO::PARAM_INT);
        $stmt->bindParam(':teamTwoGoals', $teamTwoGoals, PDO::PARAM_INT);
        $stmt->bindParam(':scheduleID', $scheduleID, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getTeamIDs($leagueID){
        $stmt = $this->database->connect()->prepare('
            SELECT "team_ID" from teams WHERE "league_ID" = :leagueID ORDER BY "team_ID"
            ');
        $stmt->bindParam(':leagueID', $leagueID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function countGames(int $teamID){
        $stmt = $this->database->connect()->prepare('
        SELECT COUNT(*) FROM schedule WHERE (team_one = :teamID or team_two = :teamID) 
                                        and team_one_goals is not null and team_two_goals is not null         
                                            ');
        $stmt->bindParam(':teamID', $teamID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function countWins(int $teamID){
        $stmt = $this->database->connect()->prepare('
            select count(*) from schedule where (team_one = :teamID and team_one_goals > schedule.team_two_goals)
                                 or
            (team_two = :teamID and team_one_goals < schedule.team_two_goals)
            and team_one_goals is not null and team_two_goals is not null
            ');
        $stmt->bindParam(':teamID', $teamID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function countLoses(int $teamID){
        $stmt = $this->database->connect()->prepare('
            select count(*) from schedule where (team_one = :teamID and team_one_goals < schedule.team_two_goals)
                                 or
            (team_two = :teamID and team_one_goals > schedule.team_two_goals)
            and team_one_goals is not null and team_two_goals is not  null
            ');
        $stmt->bindParam(':teamID', $teamID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function countGoalsScored(int $teamID){
        $stmt = $this->database->connect()->prepare('
        select sum(q1.sum1 + q2.sum2) from
                                  (select coalesce(sum(team_one_goals),0) sum1 from schedule where team_one = :teamID and team_one_goals is not null) q1,
                                  (select coalesce(sum(team_two_goals),0) sum2 from schedule where team_two = :teamID and team_two_goals is not null) q2

            ');
        $stmt->bindParam(':teamID', $teamID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function countGoalsLost(int $teamID){
        $stmt = $this->database->connect()->prepare('
            select sum(q1.sum1 + q2.sum2) from
                (select coalesce(sum(team_two_goals),0) sum1 from schedule where team_one = :teamID) q1,
                (select coalesce(sum(team_one_goals),0) sum2 from schedule where team_two = :teamID) q2
            ');
        $stmt->bindParam(':teamID', $teamID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function updateTeam(Table $updatedTeam, int $teamID){
        $stmt = $this->database->connect()->prepare('
            UPDATE score_table SET points = ?,
                                    games = ?,
                                   wins = ?,
                                   loses = ?,
                                   draws = ?,
                                   goalplus = ?,
                                   goalminus = ?
                        WHERE druzyna = ?
        ');
        $stmt->execute([$updatedTeam->getPoints(), $updatedTeam->getGames(), $updatedTeam->getWins(),
                        $updatedTeam->getLoses(), $updatedTeam->getDraws(), $updatedTeam->getGoalplus(),
                        $updatedTeam->getGoalminus(), $teamID
        ]);
    }
    public function addScheduleRow(int $teamOne, int $teamTwo, string $date, int $roundNumber){
        $stmt = $this->database->connect()->prepare('
            INSERT INTO schedule(team_one, team_two, date, "roundNumber") VALUES(?,?,?,?)
        ');
        $stmt->execute([$teamOne, $teamTwo, $date, $roundNumber]);
    }

    public function getNumberOfRound(int $leagueID){
        $stmt = $this->database->connect()->prepare('
            select max("roundNumber") from schedule s
            join teams t1 on s.team_one = t1."team_ID"
            join teams t2 on s.team_two = t2."team_ID"
            join leagues l1 on l1."leauge_id" = t1."league_ID"
            join leagues l2 on l2."leauge_id" = t2."league_ID"
            where (l1."leauge_id" = :leagueID) or ( l2."leauge_id" = :leagueID) 
        ');
        $stmt->bindParam(':leagueID', $leagueID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll()[0]["max"];
    }
}