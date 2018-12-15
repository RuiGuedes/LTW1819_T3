<?php function draw_post($channelName) { ?>
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

<?php function draw_post_aside($channel, $channelStories, $channelFollowers, $channelOwner) { ?>
    <aside> 
        <div id="channelPicture">
            <img id="asideIMG" src="../resources/images/<?= get_image('default/defaultChannel.png', '../resources/images/channels/', 'channels/', sha1($channel['name'])) ?>" alt="Channel Image"> 
        </div>
        <h3 id="channelName"><?= $channel['name'] ?></h3>
        <div id="description">
            <p>Description</p>
            <p id="descriptionContent"><?= $channel['description'] ?></p>
        </div>     
        <div id="statistics">
            <p>Channel Statistics</p>
            <div class="statistics">
                <i class="fas fa-user-lock"></i><p><?= $channelOwner ?></p>
            </div>
            <div class="statistics">
                <i class="far fa-newspaper"></i><p><?= $channelStories ?> Stories</p>    
            </div>
            <div class="statistics">
                <i class="fas fa-users"></i><p><?= $channelFollowers ?> Followers</p>
            </div>
        </div>
    </aside>
<?php } ?>