<!DOCTYPE html>
<head>
    <link rel="stylesheet" type= "text/css" href="public/css/style.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <title>Login</title>
</head>
<body class="login_body">
    <div class="login_logo">
        <img src="public/img/logo.svg">
    </div>
    <form class="login" action="login" method="POST">
            <div class="messages">
                <?php
                    if(isset($messages)){
                        foreach($messages as $message) {
                            echo $message;
                        }
                    }
                ?>
            </div>

            <input class="login_input" name="email" type="text" placeholder="email@email.com">
            <input class="login_input" name="password" type="password" placeholder="password">
        <button class="login_button" type="submit">LOGIN</button>
        <a href="http://localhost:8080/register" style="color: green">Nie masz konta? Utwórz je !</a>
    </form>
</body>