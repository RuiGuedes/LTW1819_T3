<?php function draw_channel_feed($channelStories, $storiesVotes) {
    ?>
    <div id="masterStories">
        <section id="stories">
            <?php draw_stories($channelStories, $storiesVotes) ?>
        </section>
    </div>
<?php } ?>