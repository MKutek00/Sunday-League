<?php

require_once 'AppController.php';
require_once __DIR__ .'/../models/Schedule.php';
require_once __DIR__.'/../repository/ScheduleRepository.php';
require_once __DIR__ .'/../repository/ScoreTableRepository.php';


class ScheduleController extends AppController {

    private $message = [];
    private $scheduleRepository;
    private $scoreTableRepository;

    public function __construct()
    {
        parent::__construct();
        $this->scheduleRepository = new ScheduleRepository();
        $this->scoreTableRepository = new ScoreTableRepository();
    }

    public function league_schedule(){

        $id = $_GET["id"];

        $schedule = $this->scheduleRepository->getSchedule($id);
        $numberOfRounds = $this->scheduleRepository->getNumberOfRound($id);
        return $this->render('schedule', ['schedule' => $schedule, 'numberOfRounds' => $numberOfRounds]);
    }

    public function games_result(){
        $session = Session::getInstance();
        $roleType = $session -> roleType;
        if(!isset($_SESSION['id']) or $roleType === "Klient"){
            header('Location: http://localhost:8080/news');
        }

        $id = $_GET["id"];

        $schedule = $this->scheduleRepository->getSchedule($id);
        $numberOfRounds = $this->scheduleRepository->getNumberOfRound($id);
        return $this->render('games_result', ['schedule' => $schedule, 'numberOfRounds' => $numberOfRounds]);
    }

    public function add_result(){

        $session = Session::getInstance();
        $roleType = $session -> roleType;
        if(!isset($_SESSION['id']) or $roleType === "Klient"){
            header('Location: http://localhost:8080/news');
        }

        $teamOneGoals = $_POST["teamOneGoals"];
        $teamTwoGoals = $_POST["teamTwoGoals"];
        $scheduleID = $_POST['scheduleID'];
        $leagueID = $_POST['leagueID'];
        $this->scheduleRepository->updateScore($teamOneGoals, $teamTwoGoals, $scheduleID);

        $schedule = $this->scheduleRepository->getSchedule($leagueID);
        $numberOfRounds = $this->scheduleRepository->getNumberOfRound($leagueID);
        return $this->render('schedule', ['schedule' => $schedule, 'numberOfRounds' => $numberOfRounds]);
    }

    public function refreshTable(){

        $session = Session::getInstance();
        $roleType = $session -> roleType;
        if(!isset($_SESSION['id']) or $roleType === "Klient"){
            header('Location: http://localhost:8080/news');
        }

        $allTeamsFromLeague = $this->scheduleRepository->getTeamIDs($_GET["id"]);
        foreach ($allTeamsFromLeague as $team){
            $gamesPlayed = $this->scheduleRepository->countGames($team["team_ID"])[0]['count'];
            $gamesWon = $this->scheduleRepository->countWins($team["team_ID"])[0]['count'];
            $gamesLost = $this->scheduleRepository->countLoses($team["team_ID"])[0]['count'];
            $gamesDrawn = $gamesPlayed - $gamesWon - $gamesLost;
            $points = $gamesWon * 3 + $gamesDrawn;
            $goalsScored = $this->scheduleRepository->countGoalsScored($team["team_ID"])[0]["sum"];
            if($goalsScored == NULL){
                $goalsScored = 0;
            }
            $goalsLost = $this->scheduleRepository->countGoalsLost($team["team_ID"])[0]["sum"];
            if($goalsLost == NULL){
                $goalsLost = 0;
            }

            $updatedTeam = new Table("", $points, $gamesPlayed, $gamesWon,
                                   $gamesLost, $gamesDrawn, $goalsScored, $goalsLost,
                                    0, "",0);
            $this->scheduleRepository->updateTeam($updatedTeam, $team["team_ID"]);
        }

        $tables = $this->scoreTableRepository->getScoreTable($_GET["id"]);
        return $this->render('leauge_table', ['table' => $tables]);
    }

    public function add_schedule(){
        $session = Session::getInstance();
        $roleType = $session -> roleType;
        if(!isset($_SESSION['id']) or $roleType === "Klient"){
            header('Location: http://localhost:8080/news');
        }
        if ($this->isPost() && is_uploaded_file($_FILES['file']['tmp_name'])) {

            $CSVfile = fopen($_FILES['file']['tmp_name'], "r");

            $counter = 0;
            if($CSVfile !== FALSE){
                while(! feof($CSVfile)){
                    $data = fgetcsv($CSVfile, 100, ";");
                    if($counter != 0){
                        if($data[0] != null and $data[1] != null and $data[2] != null and $data[3] != null){
                            $this->scheduleRepository->addScheduleRow($data[0], $data[1], $data[2], $data[3]);

                        }
                    }
                    else{
                        if(count($data) != 4 or strcasecmp($this->removeBomUtf8($data[0]), "team_one") != 0 or strcasecmp($data[1], "team_two") != 0 or
                            strcasecmp($data[2], "date") != 0 or strcasecmp($data[3], "roundNumber") != 0){
                            return $this->render('add_schedule', ['messages' => ["Niepoprawny format pliku CSV"]]);
                        }
                    }
                    $counter++;
                }
            }
            fclose($CSVfile);
        }


        return $this->render('add_schedule', ['messages' => ["Dodano dane do terminarza"]]);

    }

    function removeBomUtf8($s){
        if(substr($s,0,3)==chr(hexdec('EF')).chr(hexdec('BB')).chr(hexdec('BF'))){
            return substr($s,3);
        }else{
            return $s;
        }
    }

}
