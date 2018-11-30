<?php function draw_common($username, $css_files, $js_files, $filter = 2) { ?>
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

            <script src="../js/main.js" defer></script>
            <?php foreach($js_files as $js_file) { ?>
                <script src="../js/<?=$js_file?>" defer></script>
            <?php } ?>
        </head>

        <body>
            <header id="dynamicBar">
                <div id="header">
                    <img src="../resources/images/logo.png" alt="Profile Picture">
                    <h1>SiteName</h1>
                </div>
                <nav id="menu">
                    <div class="mainMenu">
                        <i class="fa fa-home"></i><a href="../pages/feed.php">Feed</a>
                    </div>
                    <div id="channelsMenu">
                        <div class="mainMenu">
                            <i class="fa fa-th-list"></i><a>Channels</a>
                        </div>
                        <ul>
                            <li><img src="../resources/images/profile.jpg" alt=""><a href="../pages/story.php">LTW</a></li>
                            <li><img src="../resources/images/profile.jpg" alt=""><a href="../pages/story.php">ESOF</a></li>
                            <li><img src="../resources/images/profile.jpg" alt=""><a href="../pages/story.php">PLOG</a></li>
                            <li><img src="../resources/images/profile.jpg" alt=""><a href="../pages/story.php">RCOM</a></li>
                            <li><img src="../resources/images/profile.jpg" alt=""><a href="../pages/story.php">LAIG</a></li>
                        </ul>
                    </div>
                    <div class="mainMenu">
                        <i class="fa fa-user-alt"></i><a href="../pages/profile.php">Profile</a>
                    </div>
                    <div class="mainMenu">
                        <i class="fa fa-sign-out-alt"></i><a href="../actions/action_logout.php">Logout</a>
                    </div>
                </nav>
            </header>
            <div id="toolBar">
                <div id="info">
                    <img src="../resources/images/profile.jpg" alt="Profile Picture">
                    <a href="../pages/profile.php"><h5><?php echo $username ?></h5></a>
                </div>
                <div id="filters">
                    <h5>Filter:</h5>
                
                    <form method="post" action="<?= $_SERVER['PHP_SELF']?>">
                        <select name="filter" id="filterID"> 
                            <option <? echo $filter == 0 ? 'selected ' : '' ?>value="0">Most Voted</option>
                            <option <? echo $filter == 1 ? 'selected ' : '' ?>value="1">Less Voted</option>
                            <option <? echo $filter == 2 ? 'selected ' : '' ?>value="2">More Recent</option>
                            <option <? echo $filter == 3 ? 'selected ' : '' ?>value="3">Less Recent</option>
                        </select>
                    </form>
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


