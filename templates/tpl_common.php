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
                    <div class="mainMenu">
                        <i class="fa fa-th-list"></i><a href="../pages/subscriptions.php">Channels</a> <!-- Change to a specific channels page -->
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
                    <a id="user-name" href="../pages/profile.php"><h5><?php echo $username ?></h5></a>
                </div>
                <div id="filters">
                    <h5>Filter:</h5>
                
                    <form method="post" action="<?= $_SERVER['PHP_SELF']?>">
                        <input type="hidden" name="channelName" value="<?= htmlentities($_POST['channelName']) ?>">
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

<?php function draw_stories($stories, $storiesVotes) {
    foreach($stories as $story) { ?> 
        <article>
            <header id="storyHeader">
                <div>
                    <div>
                        <a class="votes"><i class="fas fa-minus-circle"></i><?= htmlentities($storiesVotes[$story['storyID']]) ?><i class="fas fa-plus-circle"></i></a>
                        <h3><?= htmlentities($story['channelName']) ?></h3>
                    </div>
                    <div>
                        <span class="author"><i class="fas fa-user-alt"></i><?= htmlentities($story['storyAuthor']) ?></span>
                        <a class="comments"><i class="fas fa-comments"></i><?= htmlentities($story['storyComments']) ?></a>
                        <span class="date"><i class="fas fa-clock"></i><?= htmlentities(data_converter($story['storyTime'])) ?></span>
                    </div>
                </div>
                <div>
                    <img src="../resources/images/thumb.jpg" alt="Story Image">
                    <h1><?= htmlentities($story['storyTitle']) ?></h1>
                </div>
            </header>
            <div id="storySinopse">
                <p><?= htmlentities($story['storyContent']) ?></p>
            </div>
        </article>
    <?php } 
} ?>

<?php function draw_general_aside($channels) {
    ?>
    <aside>
        <div>
            <h1>Top 10 channels</h1>
            <form method="get" action="../pages/channel.php">
                <ul>
                    <?php 
                        foreach($channels as $channel) {
                            ?>
                            <li id="<?= $channel['channelName'] ?>" class="asideChannelList"><?= $channel['channelName'] ?></li>
                        <?php } ?>                    
                </ul>
                <input type="submit" id="submitAsideChannelName" name="channelName" visibility="hidden" style="display: none;">
            </form>
        </div>
        <form method="post" action="../pages/feed.php">
            <button id="browseChannels" type="submit">Browse channels</button>
        </form>
    </aside>
<?php } ?> 

<?php function draw_channel_aside($channel, $channelStories, $channelFollowers, $status) {
    ?>
    <aside> 
        <img id="channelImg" src="../resources/images/profile.jpg" alt="Channel Image">
        <h3 id="channelName"><?= $channel['name'] ?></h3>
        <div id="forms">
            <form>
                <?php
                    if($status) {
                      ?> <input id="subscribeButton" class="buttons" type="button" value="Unsubscribe"> <?php
                    }                        
                    else { 
                        ?><input id="subscribeButton" class="buttons" type="button" value="Subscribe"> <?php
                    }
                ?>
            </form> 
            <form method="get" action="../pages/post.php">
                <input type="hidden" name="channelName" value="<?= $channel['name'] ?>">
                <input id="addPost" class="buttons" type="submit" value="Add post">
            </form> 
        </div>
        <div id="description"> 
            <textarea id="biographyContent" maxlength="240" cols="55" rows="1" placeholder="Short Description"></textarea>
        </div>        
        <div class="statistics">
            <i class="far fa-newspaper"></i><p><?= count($channelStories) ?> Stories</p>    
        </div>
        <div class="statistics">
            <i class="fas fa-users"></i><p><?= $channelFollowers ?> Followers</p>
        </div>
    </aside>
<?php } ?>

<?php function draw_post_aside($channel, $channelStories, $channelFollowers) {
    ?>
    <aside> 
        <img id="channelImg" src="../resources/images/profile.jpg" alt="Channel Image">
        <h3 id="channelName"><?= $channel['name'] ?></h3>
        <div id="description"> 
            <textarea id="biographyContent" maxlength="240" cols="55" rows="1" placeholder="Short Description" disabled="true"></textarea>
        </div>        
        <div class="statistics">
            <i class="far fa-newspaper"></i><p><?= count($channelStories) ?> Stories</p>    
        </div>
        <div class="statistics">
            <i class="fas fa-users"></i><p><?= $channelFollowers ?> Followers</p>
        </div>
    </aside>
<?php } ?>

<?php function draw_footer() {
    ?>
        </body>
    </html>
<?php } ?>


