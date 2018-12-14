<?php function draw_post($channelName) {
    ?>
    <div id="form">
        <form method="post" enctype="multipart/form-data" action="../actions/action_add_new_post.php">
            <div id="input">
                <input type="hidden" name="channelName" value="<?= $channelName ?>">
                <input type="text" name="title" placeholder="Title" required="true">
                <input id="uploadImage"type="file" name="image" style="display: none;">
                <div id="uploadStoryPic">
                    <i class="fas fa-camera"></i>             
                    <p>Upload story picture</p>
                </div>
                <textarea id="storyContent" name="content" placeholder="Content" cols="30" rows="10" required="true"></textarea>
            </div>
            <div id="button">
                <button type="submit">Add post</button>
            </div>
        </form>
    </div>
<?php } ?>

<?php function draw_post_aside($channel, $channelStories, $channelFollowers, $channelOwner, $status) { ?>
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