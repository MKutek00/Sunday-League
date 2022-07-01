<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url( $path, PHP_URL_PATH);

Router::get('all_users','SecurityController');
Router::get('upgrade','SecurityController');
Router::get('downgrade','SecurityController');
Router::get('delete_user', 'SecurityController');



Router::get('', 'DefaultController');
Router::get('Article', 'NewsController');
Router::post('add_comm', 'NewsController');


Router::get('find_match', 'FindMatchController');

Router::get('lower_leagues', 'LeagueController');
Router::get('news', 'NewsController');

Router::post('register', 'SecurityController');
Router::post('login', 'SecurityController');
Router::post('add_news', 'NewsController');

Router::get('refreshTable', 'ScheduleController');

Router::get('league_table', 'TableController');
Router::get('league_schedule', 'ScheduleController');
Router::get('games_result', 'ScheduleController');
Router::post('add_result', 'ScheduleController');
Router::post('add_schedule', 'ScheduleController');


Router::get('get_match', 'FindMatchController');

Router::get('logout','SecurityController');

Router::run($path);