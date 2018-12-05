<?php function draw_post($channelName) {
    ?>
    <div id="form">
        <form method="post" enctype="multipart/form-data" action="../actions/action_add_new_post.php">
            <div id="input">
                <input type="hidden" name="channelName" value="<?= $channelName ?>">
                <input type="text" name="title" placeholder="Title" required="true">
                <input id="uploadImage"type="file" name="image" style="display: none;">
                <div id="uploadStoryPic">
                    <i class="fas fa-camera"></i>             
                    <p>Upload story picture</p>
                </div>
                <textarea id="storyContent" name="content" placeholder="Content" cols="30" rows="10" required="true"></textarea>
            </div>
            <div id="button">
                <button type="submit">Add post</button>
            </div>
        </form>
    </div>
<?php } ?>