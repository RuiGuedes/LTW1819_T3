<?php function draw_post() {
    ?>

    <div id="form">
        <form>
            <div id="input">
                <input type="text" name="username" placeholder="Title" required="true">
                <input id="storyImg" type="file" name="picture" placeholder="Picture" accept="image/*">
                <textarea id="storyContent" name="content" placeholder="Content" cols="30" rows="10" required="true"></textarea>
            </div>
            <div id="button">
                <button type="submit" formaction="../actions/action_addPost.php" formmethod="POST" value="send">Add post</button>
            </div>
        </form>
    </div>

    <aside> 
        <img id="channelImg" src="../resources/images/profile.jpg" alt="Channel Image">
        <h3 id="channelName">Channel Name</h3>
        <div id="biography">
            <p>Short Description</p>
        </div>        
        <div class="statistics">
            <i class="far fa-newspaper"></i><p>Y Stories</p>    
        </div>
        <div class="statistics">
            <i class="fas fa-users"></i><p>X Followers</p>
        </div>
    </aside>

<?php } ?>