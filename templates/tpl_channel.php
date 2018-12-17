<?php function draw_channel_aside($channel, $postedStories, $channelFollowers, $channelOwner, $status) { ?>
    <aside> 
        <div id="asidePicture">
            <form action="../actions/action_upload_image.php" method="post" enctype="multipart/form-data" style="display: none;">
                <input type="hidden" name="imageID" value="<?= $channel['name'] ?>">
                <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
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
                <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
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
            <?php 
                if($channelOwner === $_SESSION['username']) { ?>
                    <p>Description<button id="editDescription" type="button"><i class="fas fa-pen"></i></button></p> 
                <?php }
                else { ?>
                    <p>Description</p> 
                <?php }
            ?>
            <p id="descriptionContent"><?= $channel['description'] ?></p>
        </div>
        <div id="statistics">
            <p>Channel Statistics</p>
            <div class="statistics">
                <i class="fas fa-user-lock"></i><p><?= $channelOwner ?></p>
            </div>
            <div class="statistics">
                <i class="far fa-newspaper"></i><p><?= $postedStories ?> Stories</p>    
            </div>
            <div class="statistics">
                <i class="fas fa-users"></i><p><?= $channelFollowers ?> Followers</p>
            </div>
        </div>
    </aside>
<?php } ?>