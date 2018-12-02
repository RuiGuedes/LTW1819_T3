<?php function draw_post($channelName) {
    ?>
    <div id="form">
        <form method="post" action="../actions/action_add_new_post.php">
            <div id="input">
                <input type="hidden" name="channelName" value="<?= $channelName ?>">
                <input type="text" name="title" placeholder="Title" required="true">
                <input id="storyImg" type="file" name="picture" placeholder="Picture" accept="image/*">
                <textarea id="storyContent" name="content" placeholder="Content" cols="30" rows="10" required="true"></textarea>
            </div>
            <div id="button">
                <button type="submit">Add post</button>
            </div>
        </form>
    </div>
<?php } ?>