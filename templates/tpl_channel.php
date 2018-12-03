<?php function draw_channel_feed($channelStories, $storiesVotes) {
    include_once('../includes/functions.php');
    ?>
    <div id="masterStories">
        <section id="stories">
            <?php draw_stories($channelStories, $storiesVotes) ?>
        </section>
    </div>
<?php } ?>