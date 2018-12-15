<?php function draw_register($email, $username, $messages) { ?>
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8" />
            <title>Nescio</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" type="text/css" media="screen" href="../css/common.css" />
            <link rel="stylesheet" type="text/css" media="screen" href="../css/register.css" />
            <link href="https://fonts.googleapis.com/css?family=Exo:700|Montserrat|Muli|PT+Sans|Permanent+Marker|Poppins:500" rel="stylesheet">
        </head>
        <body>
            <header id="registerHeader">
                <a href="login.php"><img src="../resources/images/default/logo.png" alt="Site Logo"></a>
                <h1>Nescio</h1>
            </header>
            <form>
                <?=$messages?>
                <div id="input">
                    <input type="email" name="email" placeholder="Email:" required="true" value=<?=$email?>>
                    <input type="text" name="username" placeholder="Username:" required="true" value=<?=$username?>>
                    <input type="password" name="password" placeholder="Password:" required="true">
                    <input type="password" name="passwordCheck" placeholder="Confirm Password:" required="true">
                </div>
                <div id="button">
                    <button type="submit" formaction="../actions/action_register.php" formmethod="POST" value="send">Register</button>
                </div>
            </form>
        </body>
    </html>

<?php } ?>
