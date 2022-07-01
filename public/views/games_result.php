<!DOCTYPE html>
<head>
    <link rel="stylesheet" type= "text/css" href="public/css/style.css">
    <link rel="stylesheet" type= "text/css" href="public/css/schedule.css">
    <script type="text/javascript" src="./public/js/buttons.js" defer></script>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <title>Terminarz</title>
</head>
<body>
<nav class="nav_ul">
    <img src="public/img/logo.svg">
    <ul>
        <li>
            <i class="fas fa-home"></i>
            <button id="sgButton" class="leftpanel">Strona Główna</button>
        </li>
        <li>
            <i class="far fa-futbol"></i>
            <button id="fmButton" class="leftpanel">Znajdz Mecz</button>
        </li>
        <li>
            <i class="fas fa-table"></i>
            <button id="nlButton" class="leftpanel">Niższe Ligi</button>
        </li>
        <?php   $session = Session::getInstance();
        $roleType = $session -> roleType;
        $userName = $session -> name;
        if($roleType != "Klient" and $roleType != null):?>
            <li>
                <i class="fas fa-plus"></i>
                <button id="dnButton" class="leftpanel">Dodaj News</button>
            </li>

            <li>
                <i class="fas fa-plus"></i>
                <button id="aUButton" class="leftpanel">Wszyscy Użytkownicy</button>
            </li>
            <li>
                <i class="fas fa-plus"></i>
                <button id="dSButton" class="leftpanel">Dodaj Terminarz</button>
            </li>
        <?php endif;?>
        <li>
            <i class="fab fa-instagram"></i>
            <i class="fab fa-facebook-square"></i>
            <i class="fab fa-twitter"></i>
        </li>
    </ul>
</nav>
<main>
    <?php if($roleType != null): ?>
        <button id="logout">Wyloguj</button>
        <span class="userNameSpan">Zalogowany jako <?php echo($userName)?></span>
    <?php endif; ?>
    <div class="selection-container">
        <div class="selection">
            <p class="select">
                <a href="league_table?id=<?= $schedule[0]->getLeagueId();?>">TABELA
                </a>
            </p>
        </div>
        <div class="selection">
            <p class="select">
                <a href="league_schedule?id=<?= $schedule[0]->getLeagueId();?>">TERMINARZ </a>
            </p>
        </div>
    </div>
    <section class="schedule">
        <div>
            <?php for($nrKolejki = 1; $nrKolejki <= $numberOfRounds; $nrKolejki++): ?>
                <h3><i class="fas fa-long-arrow-alt-right"></i>Kolejka <?=$nrKolejki?> </h3>
                <?php foreach($schedule as $game):?>
                    <?php if($game->getRoundNumber() == $nrKolejki): ?>
                        <form action="add_result" method="POST" ENCTYPE="multipart/form-data">
                            <table>
                                <tr>
                                    <th><?= $game->getTeamOne(); ?><input name="teamOneGoals" type="text"></th>
                                    <th>-</th>
                                    <th><?= $game->getTeamTwo(); ?><input name="teamTwoGoals" type="text"></th>
                                    <th></th>
                                    <th><?= $game->getDate(); ?></th>
                                </tr>
                            </table>
                            <input type="hidden" name="scheduleID" value="<?= $game->getScheduleId()?>"></input>
                            <input type="hidden" name="leagueID" value="<?= $game->getLeagueId()?>"></input>
                            <button type="submit">Dodaj</button>
                        </form>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endfor; ?>
            <a href="refreshTable?id=<?= $schedule[0]->getLeagueId();?>"><button>ZAKTUALIZUJ TABELE </button></a>
        </div>
    </section>
</main>
</body>