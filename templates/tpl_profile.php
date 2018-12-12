<?php function draw_profile($username, $biography, $messages, $myChannels, $stories, $storiesVotes, $votedStories) {
    ?>
    <div id="masterStories">
        <section id="stories">
            <?php draw_stories($stories, $storiesVotes, $votedStories) ?>
        </section>
    </div>

    <aside> 
        <?php 
                    if(htmlentities($_GET['username']) == $_SESSION['username']) { ?>
                        <div id="asidePicture">
                            <form action="../actions/action_upload_image.php" method="post" enctype="multipart/form-data" style="display: none;">
                                <input type="hidden" name="imageID" value="<?= htmlentities($_SESSION['username']) ?>">
                                <input id="uploadImage"type="file" name="image">
                                <input id="submitImage" type="submit" value="Upload">
                            </form>
                            <?php
                                if(glob("../resources/images/users/$username.*")) { ?>
                                    <img id="asideIMG" src="../resources/images/users/<?= $username ?>" alt="User Image"> 
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
                    <?php } 
                    else { ?>
                        <div id="userPicture">
                            <?php
                                if(glob("../resources/images/users/$username.*")) { ?>
                                    <img id="asideIMG" src="../resources/images/users/<?= $username ?>" alt="User Image"> 
                                <?php }
                                else { ?>
                                    <img id="asideIMG" src="../resources/images/default/defaultUser.jpg?>" alt="User Image"> 
                                <?php }
                            ?>
                        </div>
                    <?php }                        
        ?>   
        <h3 id="username"><?= $username ?></h3>
        <?php 
            if($messages !== '')
                echo $messages;
        ?>
        <form id="forms">
            <?php 
                if(htmlentities($_GET['username']) !== $_SESSION['username']) { ?>
                    <input type="hidden" name="username" value="<?= htmlentities($_GET['username']) ?>">
                    <input type="text" name="channelName" placeholder="Channel Name" required="true" maxlength="18" disabled>
                    <button id="newChannel" type="submit" formaction="../actions/action_add_new_channel.php" formmethod="get" disabled>Create</button>
                <?php }
                else { ?>
                    <input type="hidden" name="username" value="<?= htmlentities($_GET['username']) ?>">
                    <input type="text" name="channelName" placeholder="Channel Name" required="true" maxlength="18">
                    <button id="newChannel" type="submit" formaction="../actions/action_add_new_channel.php" formmethod="get">Create</button>
                <?php }
            ?>
        </form>
        <div id="description">
            <p>Biography
                <?php 
                    if(htmlentities($_GET['username']) !== $_SESSION['username']) { ?>
                        <button id="editDescription" type="button" disabled><i class="fas fa-pen"></i></button>
                    <?php } 
                    else { ?>
                        <button id="editDescription" type="button"><i class="fas fa-pen"></i></button>
                    <?php }                        
                ?>                   
            </p>
            <p id="descriptionContent"><?=htmlentities($biography)?></p>
        </div>
        <div id="statistics">
            <p>User Statistics</p>
        </div>
    </aside>

<?php } ?>