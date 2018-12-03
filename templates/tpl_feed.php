<?php function draw_feed($stories, $storiesVotes) {
    include_once('../includes/functions.php');
    ?>
    <div id="masterStories">
        <section id="stories">
            <?php draw_stories($stories, $storiesVotes) ?>
        </section>
    </div>

<?php } ?>