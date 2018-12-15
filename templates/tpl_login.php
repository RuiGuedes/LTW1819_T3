<?php function draw_login($username, $messages) { ?>
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8" />
            <title>Nescio</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" type="text/css" media="screen" href="../css/common.css" />
            <link rel="stylesheet" type="text/css" media="screen" href="../css/login.css" />
            <link href="https://fonts.googleapis.com/css?family=Exo:700|Montserrat|Muli|PT+Sans|Permanent+Marker|Poppins:500" rel="stylesheet">
        </head>

        <body>
            <header>
                <img src="../resources/images/default/logo.png" alt="Site Logo">
                <h1>Nescio</h1>
            </header>
            <div id="form">
                <?=$messages?>
                <form>
                    <div id="input">                        
                        <input type="text" name="username" required="true" placeholder="Username" value=<?=$username?>>
                        <input type="password" name="password" placeholder="Password" required="true">
                    </div>
                    <div id="buttons">
                        <input type="button" value="Register" onclick="window.location.href='register.php'">
                        <button type="submit" formaction="../actions/action_login.php" formmethod="POST" value="send">Login</button>
                    </div>
                </form>
            </div>
        </body>
    </html>
<?php } ?>