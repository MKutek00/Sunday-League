<!DOCTYPE html>
<head>
    <link rel="stylesheet" type= "text/css" href="public/css/style.css">
    <link rel="stylesheet" type= "text/css" href="public/css/lower_leauges.css">
    <script type="text/javascript" src="./public/js/buttons.js" defer></script>


    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <title>Ligi</title>
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
                <span class="userNameSpan">Zalogowany jako <?= $userName?></span>
            <?php endif; ?>
            <img class="lowerleaugeslogo" src="public/img/lower_leauges.svg">
            <div class="lowerleaugstopic">Ligi Regionalne 2021/22 - Małopolski ZPN</div>
            <section class="lower_leauges">
                <ul class="classAlist">
                    <?php foreach($leagues as $leauge): ?>
                    <?php if($leauge->getId() > 25){break;} ?>
                    <li>
                        <a href="league_table?id=<?= $leauge->getId(); ?>"><i class="fas fa-long-arrow-alt-right"></i>
                            <?= $leauge->getName(); ?></a></li>
                    <?php endforeach ?>
                </ul>
                <ul class="classBlist">
                    <?php foreach($leagues as $leauge): ?>
                    <?php if($leauge->getId() > 25): ?>
                    <li>
                    <a href="league_table?id=<?= $leauge->getId(); ?>"><i class="fas fa-long-arrow-alt-right"></i>
                        <?= $leauge->getName(); ?></a></li>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </section>
        </main>
</body>