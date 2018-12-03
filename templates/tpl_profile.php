<?php function draw_profile($username, $biography, $myChannels, $stories, $storiesVotes) {
    include_once('../includes/functions.php');
    ?>
    <div id="masterStories">
        <section id="stories">
            <?php draw_stories($stories, $storiesVotes) ?>
        </section>
    </div>

    <aside> 
        <div id="profilePicture">
            <img id="profileImg" src="../resources/images/profile.jpg" alt="Channel Image"> 
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
                            ?> <li><a href="../pages/channel.php"><img src="../resources/images/NoImage.png" alt=""></a></li> <?php
                        }
                    }
                ?>            
            </ul>
        </div>
    </aside>

<?php } ?>