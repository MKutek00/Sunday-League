<!DOCTYPE html>
<head>
    <link rel="stylesheet" type= "text/css" href="public/css/style.css">
    <link rel="stylesheet" type= "text/css" href="public/css/games_near_you.css">

    <script type="text/javascript" src="./public/js/buttons.js" defer></script>
    <script type="text/javascript" src="./public/js/search.js" defer></script>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <title>Znajdź Mecz</title>
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
        <main class="fm-main">
            <?php if($roleType != null): ?>
                <button id="logout">Wyloguj</button>
                <span class="userNameSpan">Zalogowany jako <? echo($userName)?></span>
            <?php endif; ?>
            <div class="find-match-logo">
                <img class="fm-logo" src="public/img/prosze.svg">
            </div>
<!--        <form class="location" action="find_match" method="POST" ENCTYPE="application/x-www-form-urlencoded">-->
            <div class="location">
                <div class="first-line">
                    <i id="Icon1" class="fas fa-map-marker"></i>
                        <input class="location-input" placeholder="Miejscowość lub kod pocztowy">
                    <div class="vertical-line"></div>
                    <p class="gps-button"><i id="Icon2" class="fas fa-map-marker"></i></p>
                </div>
                <div class="second-line">
                    <input class="zakres-input" placeholder="Promień wyszukiwań (km)" type="number" min="0">
                </div>
                <button class="fm-button" type="submit">Znajdz Mecz</button>
            </div>
<!--        </form>-->
            <section class="games-near-you">
            </section>
        </main>
</body>

<template id="match-template">
    <div>
        <i class="fas fa-search-location"></i>
        <div class="right-part">
            <table>
                <tr class="upper">
                    <th class="bgf">
                        <p class = "getLocation">location</p>
                        <p class = "getDstc"></p>
                    </th>
                    <th class="ln"><p class="getLeague"></p> </th>
                    <th class="bgf"><p class="getData"></p> </th>
                </tr>
                <tr class="lower">
                    <th>    <p class="getTeamA"></p>   </th>
                    <th>    <p>----</p>                     </th>
                    <th>    <p class="getTeamB"></p>   </th>
                </tr>
            </table>
        </div>
    </div>
</template>