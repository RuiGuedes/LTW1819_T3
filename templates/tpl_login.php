<?php function draw_login() {
    ?>
    
    <!DOCTYPE html>
    <head>
        <meta charset="utf-8" />
        <title>Site Name</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" media="screen" href="../css/login.css" />
        <link href="https://fonts.googleapis.com/css?family=Exo:700|Montserrat|Muli|PT+Sans|Permanent+Marker|Poppins:500" rel="stylesheet">
    </head>

    <body>
        <header>
            <img src="../resources/images/logo.png" alt="Site Logo">
            <h1>Site Name</h1>
        </header>
        <div id="form">
            <form>
                <div id="input">
                    <input type="text" name="username" placeholder="Username" value="admin" required="true">
                    <input type="password" name="password" placeholder="Password" value="admin" required="true">
                </div>
                <div id="buttons">
                    <input type="button" value="Register" onclick="window.location.href='register.php'">
                    <button type="submit" formaction="../actions/action_login.php" formmethod="POST" value="send">Login</button>
                </div>
            </form>
        </div>
    </body>

<?php } ?>