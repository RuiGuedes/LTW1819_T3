<?php function draw_channel_aside($channel, $channelStories, $channelFollowers, $channelOwner, $status) { ?>
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