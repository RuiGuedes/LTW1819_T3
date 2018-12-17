<?php function draw_story($story, $storyVotes, $voteType, $comments, $commentVotes, $votedComments) { ?>
    <div id="masterStories"> 
        <section id="stories">
            <article id="<?= $story['storyID'] ?>">
                <header id="storyHeader">
                    <div id="story_<?= $story['storyID'] ?>_votes">
                        <div>
                            <?php 
                                if($voteType[$story['storyID']] == 1) { ?>
                                    <div class="votes">
                                        <div>
                                            <i id="voteUp" class="fas fa-chevron-up"></i>
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                        <span class="storyVotes"><?= $storyVotes[$story['storyID']] ?></span>
                                    </div>
                                <?php }
                                else if($voteType[$story['storyID']] == -1) { ?>
                                    <div class="votes">
                                        <div>
                                            <i class="fas fa-chevron-up"></i>
                                            <i id="voteDown" class="fas fa-chevron-down"></i>
                                        </div>
                                        <span class="storyVotes"><?= $storyVotes[$story['storyID']] ?></span>
                                    </div>
                                <?php }
                                else { ?>
                                    <div class="votes">
                                        <div>
                                            <i class="fas fa-chevron-up"></i>
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                        <span class="storyVotes"><?= $storyVotes[$story['storyID']] ?></span>
                                    </div>
                                <?php }
                            ?>
                            <a href="../pages/channel.php?channelName=<?= $story['channelName'] ?>"><h3><?= $story['channelName'] ?></h3></a>
                        </div>
                        <div>
                            <a class="author" href="../pages/profile.php?username=<?= $story['storyAuthor'] ?>"><i class="far fa-user"></i><?= $story['storyAuthor'] ?></a>
                            <a class="comments" href="../pages/story.php?storyID=<?= $story['storyID'] ?>"><i class="far fa-comments"></i><?= $story['storyComments'] ?></a>
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
                <div id="storyContent">
                    <p><?= $story['storyContent'] ?></p>
                </div>
            </article> 
            <?php comment_section($story['storyID'], $comments, $commentVotes, $votedComments) ?>
        </section>
    </div>
<?php } ?>

<?php function comment_section($storyID, $comments, $commentVotes, $votedComments) { ?>
        <section id="comments">
        <?php
            foreach($comments as $comment) { ?>
                <div>
                    <article>
                            <header>
                                <div id="comment_<?= $comment['commentID'] ?>_votes">
                                    <div>
                                        <?php 
                                            if($votedComments[$comment['commentID']] == 1) { ?>
                                                <div class="votes">
                                                    <div>
                                                        <i id="voteUp" class="fas fa-chevron-up"></i>
                                                        <i class="fas fa-chevron-down"></i>
                                                    </div>
                                                    <span class="storyVotes"><?= $commentVotes[$comment['commentID']] ?></span>
                                                </div>
                                            <?php }
                                            else if($votedComments[$comment['commentID']] == -1) { ?>
                                                <div class="votes">
                                                    <div>
                                                        <i class="fas fa-chevron-up"></i>
                                                        <i id="voteDown" class="fas fa-chevron-down"></i>
                                                    </div>
                                                    <span class="storyVotes"><?= $commentVotes[$comment['commentID']] ?></span>
                                                </div>
                                            <?php }
                                            else { ?>
                                                <div class="votes">
                                                    <div>
                                                        <i class="fas fa-chevron-up"></i>
                                                        <i class="fas fa-chevron-down"></i>
                                                    </div>
                                                    <span class="storyVotes"><?= $commentVotes[$comment['commentID']] ?></span>
                                                </div>
                                            <?php }
                                        ?>
                                    <span class="author"><i class="far fa-user"></i><?= $comment['commentAuthor'] ?></span>
                                    </div>
                                    <div>
                                        <span class="reply"><i class="fas fa-reply"></i></i>Reply</span>
                                        <span class="expand"><i class="fas fa-stream"></i></i>Expand</span>
                                        <span class="date"><i class="far fa-clock"></i><?= data_converter($comment['commentTime']) ?></span>
                                    </div>
                                </div>
                            </header>
                            <p><?= $comment['commentContent'] ?></p>
                        </article> 
                </div>
            <?php }
        ?> 
        <div>
            <form method="post" action="../actions/action_add_comment.php">
                <textarea name="content" cols="30" rows="5" required placeholder="Write a story related comment ..."></textarea>
                <input type="hidden" name="storyID" value="<?= htmlentities($storyID) ?>">
                <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
                <input type="submit" id="submitCommentForm" value="Comment">
            </form>                    
        </div>
    </section> 
<?php } ?>