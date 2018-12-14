<?php function draw_common($username, $css_files, $js_files, $filter = 2) {
    ?>
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
                    <img src="../resources/images/default/logo.png" alt="Logo">
                    <h1>Nescio</h1>
                </div>
                <nav id="menu">
                    <div class="mainMenu">
                        <i class="fa fa-home"></i><a href="../pages/feed.php">Feed</a>
                    </div>
                    <div class="mainMenu">
                        <i class="fa fa-th-list"></i><a href="../pages/subscriptions.php">Channels</a> <!-- Change to a specific channels page -->
                    </div>
                    <div class="mainMenu">
                        <i class="fa fa-user-alt"></i><a href="../pages/profile.php?username=<?= $_SESSION['username'] ?>">Profile</a>
                    </div>
                    <div class="mainMenu">
                        <i class="fa fa-sign-out-alt"></i><a href="../actions/action_logout.php">Logout</a>
                    </div>
                </nav>
            </header>
            <div id="toolBar">
                <div id="info">
                    <img id="asideIMG" src="../resources/images/<?= get_image('default/defaultUser.jpg', '../resources/images/users/', 'users/', sha1($_SESSION['username'])) ?>" alt="User Image"> 
                    <a id="user-name" href="../pages/profile.php?username=<?= $_SESSION['username'] ?>"><h5><?php echo $username ?></h5></a>
                </div>
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
                        ?>
                        <select name="filter" id="filterID"> 
                            <option <? echo $filter == 0 ? 'selected ' : '' ?>value="0">Most Voted</option>
                            <option <? echo $filter == 1 ? 'selected ' : '' ?>value="1">Less Voted</option>
                            <option <? echo $filter == 2 ? 'selected ' : '' ?>value="2">More Recent</option>
                            <option <? echo $filter == 3 ? 'selected ' : '' ?>value="3">Less Recent</option>
                        </select>
                    </form>
                </div>
                <div id="search">
                    <input type="search" name="Search" placeholder="Search ...">
                </div>
            </div>
<? } ?>

<?php function draw_stories($stories, $storiesVotes, $votedStories) {
    foreach($stories as $story) { ?> 
        <article id="<?= $story['storyID'] ?>" class="storyArticle">
            <header id="storyHeader">
                <div id="story_<?= $story['storyID'] ?>_votes" >
                    <div>
                        <?php 
                            if($votedStories[$story['storyID']] == 1) { ?>
                                <div class="votes">
                                    <div>
                                        <i id="voteUp" class="fas fa-chevron-up"></i>
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                    <span class="storyVotes"><?= htmlentities($storiesVotes[$story['storyID']]) ?></span>
                                </div>
                            <?php }
                            else if($votedStories[$story['storyID']] == -1) { ?>
                                <div class="votes">
                                    <div>
                                        <i class="fas fa-chevron-up"></i>
                                        <i id="voteDown" class="fas fa-chevron-down"></i>
                                    </div>
                                    <span class="storyVotes"><?= htmlentities($storiesVotes[$story['storyID']]) ?></span>
                                </div>
                            <?php }
                            else { ?>
                                <div class="votes">
                                    <div>
                                        <i class="fas fa-chevron-up"></i>
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                    <span class="storyVotes"><?= htmlentities($storiesVotes[$story['storyID']]) ?></span>
                                </div>
                            <?php }
                        ?>
                        <h3><?= $story['channelName'] ?></h3>
                    </div>
                    <div>
                        <span class="author"><i class="far fa-user"></i><?= $story['storyAuthor'] ?></span>
                        <span class="comments"><i class="far fa-comments"></i><?= $story['storyComments'] ?></span>
                        <span class="date"><i class="far fa-clock"></i><?= data_converter($story['storyTime']) ?></span>
                    </div>
                </div>
                <div> 
                    <h1><?= $story['storyTitle'] ?></h1> 
                    <?php 
                        $image = get_image('', '../resources/images/stories/', 'stories/', sha1($story['storyID']));
                        if($image !== '') {
                            ?> <img src="../resources/images/<?= $image ?>" alt="Story Image">
                        <?php }
                    ?>
                </div>
            </header>
            <div id="storySinopse">
                <p><?= $story['storyContent'] ?></p>
            </div>
        </article>
    <?php } 
} ?>

<?php function draw_general_aside($channels, $messages) {
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
        <?php 
            if($messages !== '')
                echo $messages;
        ?>
        <form method="post" action="../pages/feed.php">
            <button id="browseChannels" type="submit">Browse channels</button>
        </form>
    </aside>
<?php } ?> 

<?php function draw_channel_aside($channel, $channelStories, $channelFollowers, $channelOwner, $status) {
    ?>
    <aside> 
        <div id="asidePicture">
            <form action="../actions/action_upload_image.php" method="post" enctype="multipart/form-data" style="display: none;">
                <input type="hidden" name="imageID" value="<?= $channel['name'] ?>">
                <input id="uploadImage"type="file" name="image">
                <input id="submitImage" type="submit" value="Upload">
            </form>
            <img id="asideIMG" src="../resources/images/<?= get_image('default/defaultChannel.png', '../resources/images/channels/', 'channels/', sha1($channel['name'])) ?>" alt="Channel Image"> 
            <div>
                <i class="fas fa-camera"></i>             
                <p>Update</p>
            </div>
        </div>
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
            <p>Description<button id="editDescription" type="button"><i class="fas fa-pen"></i></button></p>
            <p id="descriptionContent"><?=htmlentities($channel['description'])?></p>
        </div>
        <div id="statistics">
            <p>Channel Statistics</p>
            <div class="statistics">
                <i class="fas fa-user-lock"></i><p><?= $channelOwner ?></p>
            </div>
            <div class="statistics">
                <i class="far fa-newspaper"></i><p><?= count($channelStories) ?> Stories</p>    
            </div>
            <div class="statistics">
                <i class="fas fa-users"></i><p><?= $channelFollowers ?> Followers</p>
            </div>
        </div>
    </aside>
<?php } ?>

<?php function draw_post_aside($channel, $channelStories, $channelFollowers, $channelOwner, $status) {
    ?>
    <aside> 
        <div id="channelPicture">
            <img id="asideIMG" src="../resources/images/<?= get_image('default/defaultChannel.png', '../resources/images/channels/', 'channels/', sha1($channel['name'])) ?>" alt="Channel Image"> 
        </div>
        <h3 id="channelName"><?= $channel['name'] ?></h3>
        <div id="forms">
            <form>
                <?php
                    if($status) {
                      ?> <input class="buttons" type="button" value="Unsubscribe" disabled> <?php
                    }                        
                    else { 
                        ?><input class="buttons" type="button" value="Subscribe" disabled> <?php
                    }
                ?>
            </form> 
            <form method="get" action="../pages/post.php">
                <input type="hidden" name="channelName" value="<?= $channel['name'] ?>">
                <input class="buttons" type="submit" value="Add post" disabled>
            </form> 
        </div>
        <div id="description">
            <p>Description</p>
            <p id="descriptionContent"><?=htmlentities($channel['description'])?></p>
        </div>     
        <div id="statistics">
            <p>Channel Statistics</p>
            <div class="statistics">
                <i class="fas fa-user-lock"></i><p><?= $channelOwner ?></p>
            </div>
            <div class="statistics">
                <i class="far fa-newspaper"></i><p><?= count($channelStories) ?> Stories</p>    
            </div>
            <div class="statistics">
                <i class="fas fa-users"></i><p><?= $channelFollowers ?> Followers</p>
            </div>
        </div>
    </aside>
<?php } ?>

<?php function draw_footer() {
    ?>
        </body>
    </html>
<?php } ?>


