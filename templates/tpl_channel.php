<?php function draw_channel_feed($channelStories, $storiesVotes, $votedStories) {
    ?>
    <div id="masterStories">
        <section id="stories">
            <?php draw_stories($channelStories, $storiesVotes, $votedStories) ?>
        </section>
    </div>
<?php } ?>