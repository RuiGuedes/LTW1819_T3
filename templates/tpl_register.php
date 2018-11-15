<?php function draw_register() {
    ?>
    <!DOCTYPE <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8" />
        <title>Site Name</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" media="screen" href="../css/register.css" />
        <link href="https://fonts.googleapis.com/css?family=Exo:700|Montserrat|Muli|PT+Sans|Permanent+Marker|Poppins:500" rel="stylesheet">
    </head>
    <body>
        <header id="header">
            <a href="login.php"><img src="../resources/images/logo.png" alt="Site Logo"></a>
            <h1>Site Name</h1>
        </header>
        <div id="form">
            <form>
                <div id="input">
                    <input type="email" name="email" placeholder="Email:" required="true">
                    <input type="text" name="username" placeholder="Username:" required="true">
                    <input type="password" name="password" placeholder="Password:" required="true">
                    <input type="password" name="passwordCheck" placeholder="Confirm Password:" required="true">
                </div>
                <div id="button">
                    <button type="submit" formaction="../actions/action_register.php" formmethod="POST" value="send">Register</button>
                </div>
            </form>
        </div>
    </body>
    </html>

<?php } ?>
