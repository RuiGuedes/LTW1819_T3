<?php function draw_stories($stories, $storiesVotes, $votedStories) { ?>
    <div id="masterStories">
        <form method="get" action="../pages/story.php">
            <section id="stories">  <?php
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
                                    <a href="../pages/channel.php?channelName=<?= $story['channelName'] ?>"><h3><?= $story['channelName'] ?></h3></a>
                                </div>
                                <div>
                                    <a class="author" href="../pages/profile.php?username=<?= $story['storyAuthor'] ?>"><i class="far fa-user"></i><?= $story['storyAuthor'] ?></a>
                                    <a class="comments" href="../pages/story.php?storyID=<?= $story['storyID'] ?>#comments"><i class="far fa-comments"></i><?= $story['storyComments'] ?></a>
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
                <?php } ?>
            </section>
            <input type="submit" id="submitStoryForm" name="storyID" visibility="hidden" style="display: none;">
        </form>
    </div>
<?php } ?>