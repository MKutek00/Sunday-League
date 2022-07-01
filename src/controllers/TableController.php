<?php

require_once 'AppController.php';
require_once __DIR__ .'/../models/Table.php';
require_once __DIR__.'/../repository/ScoreTableRepository.php';

class TableController extends AppController {

    private $message = [];
    private $scoreTableRepository;

    public function __construct()
    {
        parent::__construct();
        $this->scoreTableRepository = new ScoreTableRepository();
    }

    public function league_table(){

        $id = $_GET["id"];
        $tables = $this->scoreTableRepository->getScoreTable($id);
        return $this->render('leauge_table', ['table' => $tables]);
    }


}
