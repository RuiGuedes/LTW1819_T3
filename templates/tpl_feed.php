<?php function draw_feed($stories, $storiesVotes, $votedStories) {
    ?>
    <div id="masterStories">
        <form method="get" action="../pages/story.php">
            <section id="stories">            
                    <?php draw_stories($stories, $storiesVotes, $votedStories) ?>
            </section>
            <input type="submit" id="submitStoryForm" name="storyID" visibility="hidden" style="display: none;">
        </form>
    </div>

<?php } ?>