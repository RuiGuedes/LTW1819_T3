<?php function draw_feed($stories, $storiesVotes, $votedStories) {
    ?>
    <div id="masterStories">
        <section id="stories">
            <?php draw_stories($stories, $storiesVotes, $votedStories) ?>
        </section>
    </div>

<?php } ?>