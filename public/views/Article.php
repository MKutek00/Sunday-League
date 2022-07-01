<!DOCTYPE html>
<head>
    <link rel="stylesheet" type= "text/css" href="public/css/style.css">
    <script type="text/javascript" src="./public/js/buttons.js" defer></script>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <title><?= $article->getTitle();?></title>
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
<main class="article_main">
    <?php if($roleType != null): ?>
        <button id="logout">Wyloguj</button>
        <span class="userNameSpan">Zalogowany jako <? echo($userName)?></span>
    <?php endif; ?>
    <section class="Article">
        <h1 class="article_title"><?= $article->getTitle();?></h1>
        <p class="article_shortDescription"><?= $article->getShortDescription();?></p>
        <img src="public/img/uploads/<?= $article->getImage(); ?>" class="article_img" alt=""/>
        <p class="article_text"><?= $article->getDescription();?></p>
        <div class="article_ads"></div>
    </section>
    <span class="article_span">Komentarze</span>

    <section class="article_comments">
        <?php if($roleType != null): ?>
        <div class="article_comm">
            <form action="add_comm?id=<?= $_GET["id"]; ?>" method="POST" ENCTYPE="multipart/form-data">
                <img src="public/img/ikona.svg" class="comm_img" alt="">
                <input type="hidden" name="comm_author" class="comm_username" value=""><?php echo($userName)?></input>
                <div class="messages">
                    <?php
                    if(isset($messages)){
                        foreach($messages as $message) {
                            echo $message;
                        }
                    }
                    ?>
                </div>
                <textarea class="comm_text" name="add_commText" rows=4 placeholder="Twój komentarz"></textarea>
                <button class="add_commButton" type="submit">Dodaj komentarz</button>
            </form>
        </div>
        <?php endif ?>
        <?php foreach($comments as $comm): ?>

        <div class="article_comm">
            <img src="public/img/ikona.svg" class="comm_img" alt="">
            <span class="comm_username"><?= $comm->getUserName(); ?></span>
            <span class="comm_text"><?= $comm->getText(); ?></span>
            <span class="comm_date"><?= $comm->getDate(); ?></span>
        </div>
        <?php endforeach; ?>
    </section>


</main>
</body>