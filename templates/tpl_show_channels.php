<?php function draw_channels_list($channels) { ?>
    <div id="masterChannels">
        <section id="channels">
            <form method="get" action="../pages/channel.php">
                <?php foreach($channels as $channel) { ?> 
                    <article id="<?= $channel['name'] ?>" class="channelArticle">
                        <header id="channelHeader">
                            <div>
                                <div>
                                    <p>Channel name:</p><h1><?= $channel['name'] ?></h1>
                                </div>
                                <div>
                                    <p>Owner:</p><h1><a href="../pages/profile.php?username=<?= $channel['owner'] ?>"><?= $channel['owner'] ?></a></h1>
                                </div>
                            </div>
                            <div>     
                                <img id="asideIMG" src="../resources/images/<?= get_image('default/defaultChannel.png', '../resources/images/channels/', 'channels/', sha1($channel['name'])) ?>" alt="Channel Image">              
                                <div id="channelDescription">
                                    <h1>Description:</h1><p><?= $channel['description'] ?></p>
                                </div>
                            </div>
                        </header>
                    </article>
                <?php } ?>
                <input type="submit" id="submitChannelName" name="channelName" visibility="hidden" style="display: none;">
            </form>
        </section>
    </div>
<?php } ?>