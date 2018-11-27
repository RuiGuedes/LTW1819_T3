<?php function draw_profile($username, $myChannels, $stories) {
    ?>

    <div id="masterStories">
        <section id="stories">
            <?php 
                foreach($stories as $story) {
                ?>  
                    <article>
                        <header id="storyHeader">
                            <div>
                                <div>
                                <a class="votes"><i class="fas fa-minus-circle"></i><?= $story['storyPoints'] ?><i class="fas fa-plus-circle"></i></a>
                                <h3><?= $story['channelName'] ?></h3>
                            </div>
                            <div>
                                <span class="author"><i class="fas fa-user-alt"></i><?= $story['storyAuthor'] ?></span>
                                <a class="comments"><i class="fas fa-comments"></i><?= $story['storyComments'] ?></a>
                                <span class="date"><i class="fas fa-clock"></i><?= $story['storyTime'] ?></span>
                            </div>
                            </div>
                            <div>
                                <img src="../resources/images/thumb.jpg" alt="Story Image">
                                <h1><?= $story['storyTitle'] ?></h1>
                            </div>
                        </header>
                        <div id="storySinopse">
                            <p><?= $story['storyContent'] ?></p>
                        </div>
                    </article>
                <?php
                }
            ?>
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
        </div>        
        <div class="myChannels">
            <p>My Channels</p>
            <ul>
                <?php 
                    if(count($myChannels) === 0) {
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