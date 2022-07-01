<!DOCTYPE html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Fjalla+One" rel="stylesheet"> 
    <link rel="stylesheet" type= "text/css" href="public/css/style.css">
    <script type="text/javascript" src="./public/js/buttons.js" defer></script>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">    
    <title>Tabela</title>
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
            <span class="userNameSpan">Zalogowany jako <? echo($userName)?></span>
        <?php endif; ?>
        <div class="selection-container">
            <div class="selection">
                <p class="select">
                    <a href="league_table?id=<?= $table[0]->getLeaugeId();?>">TABELA </a>
                </p>
            </div>
            <div class="selection">
                <p class="select">
                    <a href="league_schedule?id=<?= $table[0]->getLeaugeId();?>">TERMINARZ </a>
                </p>
            </div>
        </div>
        <div class="ptable">
            <h1 class="headin"><?= $table[0]->getLeaugeName();?></h1>
            <table>
                <tr class="definition">
                    <th>#</th>
                    <th colspan="2">Drużyny</th>
                    <th>Punkty</th>
                    <th>Mecze</th>
                    <th>Wygrane</th>
                    <th>Remisy</th>
                    <th>Porażki</th>
                    <th>Bramki+</th>
                    <th>Bramki-</th>
                    <th>Bilans</th>
                </tr>
                <tr class="short-definition">
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>P</th>
                    <th>M</th>
                    <th>W</th>
                    <th>R</th>
                    <th>P</th>
                    <th>B+</th>
                    <th>B-</th>
                    <th>B+/B-</th>
                </tr>
                    <?php $step=1;foreach($table as $record):?>
                <tr class="<?php if($step < 3){echo"promotion";}elseif($step > sizeof($table)-2){echo"decrease";}else{echo"normal";}?>">
                    <td><?php echo $step;?></td>
                    <td colspan="2"><?= $record->getName(); ?></td>
                    <td><?= $record->getPoints(); ?></td>
                    <td><?= $record->getGames(); ?></td>
                    <td><?= $record->getWins(); ?></td>
                    <td><?= $record->getLoses(); ?></td>
                    <td><?= $record->getDraws(); ?></td>
                    <td><?= $record->getGoalplus(); ?></td>
                    <td><?= $record->getGoalminus(); ?></td>
                    <td><?= $record->getGoalplusminus(); ?></td>
                </tr>
                    <?php $step += 1;endforeach; ?>
            </table>
        </div>
    </main>
</body>