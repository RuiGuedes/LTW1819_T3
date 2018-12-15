<?php function draw_common($username, $css_files, $js_files, $filter, $searchFilter) { ?>
    <!DOCTYPE <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8" />
            <title>Nescio</title>
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
            <?php draw_dynamic_bar($username) ?>
            <?php draw_tool_bar($username, $filter, $searchFilter) ?>
<?php } ?>

<?php function draw_dynamic_bar($username) { ?>
    <header id="dynamicBar">
        <div id="header">
            <img src="../resources/images/default/logo.png" alt="Logo">
            <h1>Nescio</h1>
        </div>
        <nav id="menu">
            <div class="mainMenu">
                <i class="fa fa-home"></i><a href="../pages/feed.php">Feed</a>
            </div>
            <div class="mainMenu">
                <i class="fa fa-th-list"></i><a href="../pages/show_channels.php?show=subscriptions">Channels</a> 
            </div>
            <div class="mainMenu">
                <i class="fa fa-user-alt"></i><a href="../pages/profile.php?username=<?= $username ?>">Profile</a>
            </div>
            <div class="mainMenu">
                <i class="fa fa-sign-out-alt"></i><a href="../actions/action_logout.php">Logout</a>
            </div>
        </nav>
    </header>
<? } ?>


<?php function draw_tool_bar($username, $filter, $searchFilter) { ?>
    <div id="toolBar">
        <div id="info">
            <img id="asideIMG" src="../resources/images/<?= get_image('default/defaultUser.jpg', '../resources/images/users/', 'users/', sha1($username)) ?>" alt="User Image"> 
            <a id="user-name" href="../pages/profile.php?username=<?= $username ?>"><h5><?= $username ?></h5></a>
        </div>
        <?php draw_story_filter($filter) ?>
        <?php draw_search_filter($searchFilter) ?>
    </div>
<? } ?>

<?php function draw_story_filter($filter) { ?>
    <div id="filters">
        <h5>Filter:</h5>
        <form method="get" action="<?= $_SERVER['PHP_SELF']?>">
            <?php 
                if(isset($_GET['channelName'])) {
                    ?> <input type="hidden" name="channelName" value="<?= htmlentities($_GET['channelName']) ?>">
                <?php } 
                if(isset($_GET['username'])) {
                    ?> <input type="hidden" name="username" value="<?= htmlentities($_GET['username']) ?>">
                <?php }
                if(isset($_GET['searchFilter']) && isset($_GET['search'])) { ?> 
                    <input type="hidden" name="searchFilter" value="<?= htmlentities($_GET['searchFilter']) ?>">
                    <input type="hidden" name="search" value="<?= htmlentities($_GET['search']) ?>">
                <?php }
            ?>
            <select name="filter" id="filterID"> 
                <option <? echo $filter == 0 ? 'selected ' : '' ?>value="0">Most Voted</option>
                <option <? echo $filter == 1 ? 'selected ' : '' ?>value="1">Less Voted</option>
                <option <? echo $filter == 2 ? 'selected ' : '' ?>value="2">More Recent</option>
                <option <? echo $filter == 3 ? 'selected ' : '' ?>value="3">Less Recent</option>
                <option <? echo $filter == 4 ? 'selected ' : '' ?>value="4">Most Commented</option>
                <option <? echo $filter == 5 ? 'selected ' : '' ?>value="5">Less Commented</option>
            </select>
        </form>
    </div>
<? } ?>

<?php function draw_search_filter($searchFilter) { ?>
    <div id="search">
        <form method="get" action="<?= $_SERVER['PHP_SELF']?>">
            <input type="hidden" name="filter">
            <?php 
                if(isset($_GET['channelName'])) {
                    ?> <input type="hidden" name="channelName" value="<?= htmlentities($_GET['channelName']) ?>">
                <?php } 
                if(isset($_GET['username'])) {
                    ?> <input type="hidden" name="username" value="<?= htmlentities($_GET['username']) ?>">
                <?php }
            ?>
            <select name="searchFilter" id="searchFilterID"> 
                <option <? echo $searchFilter == 0 ? 'selected ' : '' ?>value="0">Channel</option>
                <option <? echo $searchFilter == 1 ? 'selected ' : '' ?>value="1">Author</option>
                <option <? echo $searchFilter == 2 ? 'selected ' : '' ?>value="2">Story</option>
            </select>
            <input type="search" id="searchField" name="search" placeholder="Search ...">
        </form>
    </div>
<? } ?>

<?php function draw_footer() { ?>
        </body>
    </html>
<?php } ?>


