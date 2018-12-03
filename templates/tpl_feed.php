<?php function draw_feed($stories, $storiesVotes) {
    ?>
    <div id="masterStories">
        <section id="stories">
            <?php draw_stories($stories, $storiesVotes) ?>
        </section>
    </div>

<?php } ?>