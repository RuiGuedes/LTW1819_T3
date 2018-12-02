<?php function draw_channel_feed($channel, $channelStories) {
    ?>
    <div id="masterStories">
        <section id="stories">
            <?php
                foreach($channelStories as $story) {
                    ?>
                    <article>
                        <header id="storyHeader">
                            <div>
                                <div>
                                    <a class="votes"><i class="fas fa-minus-circle"></i><?= $story['storyPoints'] ?><i class="fas fa-plus-circle"></i></a>
                                    <h3><?= $channel['name'] ?></h3>
                                </div>
                                <div>
                                    <span class="author"><i class="fas fa-user-alt"></i><?= $story['storyAuthor'] ?></span>
                                    <a class="comments"><i class="fas fa-comments"></i><?= $story['storyComments'] ?></a>
                                    <span class="date"><i class="fas fa-clock"></i><?= $story['storyTime'] ?></span>
                                </div>
                            </div>
                            <div>
                                <img src="../resources/images/thumb.jpg" alt="Story Image"> <!-- TODO - Image of a story -->
                                <h1><?= $story['storyTitle'] ?></h1>
                            </div>
                        </header>
                        <div id="storySinopse">
                            <p><?= $story['storyContent'] ?></p>
                        </div>
                    </article>
                <?php } ?>
        </section>
    </div>
<?php } ?>