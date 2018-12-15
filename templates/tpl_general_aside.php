<?php function draw_general_aside($channels, $messages) { ?>
    <aside>
        <div>
            <h1>Top 10 channels</h1>
            <form method="get" action="../pages/channel.php">
                <ul>
                    <?php 
                        foreach($channels as $channel) { ?>
                            <li id="<?= $channel['channelName'] ?>" class="asideChannelList"><?= $channel['channelName'] ?></li>
                        <?php } 
                    ?>                    
                </ul>
                <input type="submit" id="submitAsideChannelName" name="channelName" visibility="hidden" style="display: none;">
            </form>
        </div>
        <?= $messages ?>
        <form method="get" action="../pages/show_channels.php">
            <input type="hidden" name="show" value="all">
            <button id="browseChannels" type="submit">Browse channels</button>
        </form>
    </aside>
<?php } ?> 