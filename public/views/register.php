<!DOCTYPE html>
<head>
    <link rel="stylesheet" type= "text/css" href="public/css/style.css">
    <script type="text/javascript" src="./public/js/script.js" defer></script>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <title>Rejestracja</title>
</head>
<body class="login_body">
    <div class="login_logo">
        <img src="public/img/logo.svg">
    </div>
    <form class="register" action="register" method="POST">
        <div class="messages">
            <?php
            if(isset($messages)){
                foreach($messages as $message) {
                    echo $message;
                }
            }
            ?>
        </div>
        <input name="name" type="text" placeholder="name">
        <input name="email" type="text" placeholder="email@email.com">
        <input name="password" type="password" placeholder="password">
        <input name="confirmedPassword" type="password" placeholder="password">

        <button type="submit">REGISTER</button>
    </form>
</body>