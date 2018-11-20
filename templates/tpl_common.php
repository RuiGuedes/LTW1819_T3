<?php function draw_common($username, $css_files) { ?>
    <!DOCTYPE <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8" />
            <title> Site Name </title>
            <meta name="viewport" content="width=device-width, initial-scale=1">

            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
            <link href="https://fonts.googleapis.com/css?family=Exo:700|Montserrat|Muli|PT+Sans|Permanent+Marker|Poppins:500" rel="stylesheet">

            <link rel="stylesheet" type="text/css" media="screen" href="../css/common.css" />
            <?php foreach($css_files as $css_file) { ?>
                <link rel="stylesheet" type="text/css" media="screen" href="../css/<?=$css_file?>" />
            <?php } ?>
        </head>

        <body>
            <header id="dynamicBar">
                <div id="header">
                    <img src="../resources/images/logo.png" alt="Profile Picture">
                    <h1>SiteName</h1>
                </div>
                <nav id="menu">
                    <div>
                        <i class="fa fa-home"></i><a>Feed</a>
                    </div>
                    <div>
                        <i class="fa fa-th-list"></i><a>Channels</a>
                    </div>
                    <div>
                        <i class="fa fa-user-alt"></i><a>Profile</a>
                    </div>
                    <div>
                        <i class="fa fa-sign-out-alt"></i><a href="../actions/action_logout.php">Logout</a>
                    </div>
                </nav>
            </header>
            <div id="toolBar">
                <div id="info">
                    <img src="../resources/images/profile.jpg" alt="Profile Picture">
                    <h5><?php echo $username ?></h5>
                </div>
                <div id="filters">
                    <h5>Filter:</h5>
                    <select name="Votes" id="VotesFilterID">
                        <option value="">Votes</option>
                        <option value="MostVoted">Most Voted</option>
                        <option value="LessVoted">Less Voted</option>
                    </select>
                    <select name="Time" id="TimeFilterID">
                        <option value="">Time</option>
                        <option value="MoreRecente">More Recent</option>
                        <option value="LessRecente">Less Recent</option>
                    </select>
                </div>
                <div id="search">
                    <input type="search" name="Search" placeholder="Search">
                </div>
            </div>
<? } ?>

<?php function draw_footer() {
    ?>
        </body>
    </html>

<?php } ?>


