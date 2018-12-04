<?php function draw_profile($username, $biography, $myChannels, $stories, $storiesVotes, $votedStories) {
    ?>
    <div id="masterStories">
        <section id="stories">
            <?php draw_stories($stories, $storiesVotes, $votedStories) ?>
        </section>
    </div>

    <aside> 
        <div id="asidePicture">
            <form action="../actions/action_upload_image.php" method="post" enctype="multipart/form-data" style="display: none;">
                <input type="hidden" name="imageID" value="<?= htmlentities($_SESSION['username']) ?>">
                <input id="uploadImage"type="file" name="image">
                <input id="submitImage" type="submit" value="Upload">
            </form>
            <?php
                $imageID = $_SESSION['username'];
                if(glob("../resources/images/users/$imageID.*")) { ?>
                    <img id="asideIMG" src="../resources/images/users/<?= $_SESSION['username'] ?>" alt="User Image"> 
                <?php }
                else { ?>
                    <img id="asideIMG" src="../resources/images/default/defaultUser.jpg?>" alt="User Image"> 
                <?php }
            ?>
            <div>
                <i class="fas fa-camera"></i>             
                <p>Update</p>
            </div>
        </div>
        <h3 id="username"><?= $username ?></h3>
        <?php 
            if(isset($_SESSION['messages'])) { ?>
                <section id="messages"> <?php
                foreach($_SESSION['messages'] as $message) {
                    ?><div class="<?=$message['type']?>"><?=$message['content']?></div> <?php 
                } ?>
                </section> <?php
            }
            unset($_SESSION['messages']);
        ?>
        <form>
            <input type="text" name="channelName" placeholder="Channel Name" required="true" maxlength="18">
            <button id="newChannel" type="submit" formaction="../actions/action_add_new_channel.php" formmethod="POST">Create</button>
        </form>
        <div id="description">
            <p>Biography<button id="editDescription" type="button"><i class="fas fa-pen"></i></button></p>
            <p id="descriptionContent"><?=$biography?></p>
        </div>        
        <div class="myChannels">
            <p>My Channels</p>
            <ul>
                <?php 
                    if(empty($myChannels)) {
                        ?> <p id="noChannels">Empty</p> <?php
                    }
                    else {
                        foreach($myChannels as $channel) {
                            ?> <li><a href="../pages/channel.php"><img src="../resources/images/NoImage.png" alt="To remove this"></a></li> <?php
                        }
                    }
                ?>            
            </ul>
        </div>
    </aside>

<?php } ?>