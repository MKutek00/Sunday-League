<!DOCTYPE html>
<head>
    <link rel="stylesheet" type= "text/css" href="public/css/style.css">
    <link rel="stylesheet" type= "text/css" href="public/css/add_news.css">
    <script type="text/javascript" src="./public/js/buttons.js" defer></script>
    <script type="text/javascript" src="./public/js/roles.js" defer></script>


    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <title>Dodaj News</title>
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
    <header class="h_users">Wszyscy Użytkownicy</header>
    <table class="all_users_table">
        <tr>
            <th>User_ID</th>
            <th>Nazwa Użytkownika</th>
            <th>E-mail</th>
            <th>Rola</th>
            <th>Upgrade</th>
            <th>Downgrade</th>
            <th>Delete</th>
        </tr>
        <?php foreach($users as $user): ?>
        <tr id="<?= $user->getIdUser(); ?>">
            <td><?= $user->getIdUser(); ?></td>
            <td><?= $user->getName(); ?></td>
            <td><?= $user->getEmail(); ?></td>
            <td class="roleType"><?= $user->getRoleName(); ?></td>
            <td class="upgrade">+</td>
            <td class="downgrade">-</td>
            <td class="delete">Delete</td>
        </tr>
        <?php endforeach;?>

    </table>


</main>
</body>