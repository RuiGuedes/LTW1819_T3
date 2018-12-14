<?php function draw_user_subscriptions($subscriptions) {
    ?>

    <div id="masterSubscriptions">
        <section id="subscriptions">
            <form method="get" action="../pages/channel.php">
                <?php foreach($subscriptions as $subscription) {
                    ?> 
                    <article id="<?= $subscription['name'] ?>" class="subscriptionArticle">
                        <header id="subscriptionHeader">
                            <div>
                                <div>
                                    <p>Channel name:</p><h1><?= $subscription['name'] ?></h1>
                                </div>
                                <div>
                                    <p>Owner:</p><h1><?= $subscription['owner'] ?></h1>
                                </div>
                            </div>
                            <div>     
                                <img id="asideIMG" src="../resources/images/<?= get_image('default/defaultChannel.png', '../resources/images/channels/', 'channels/', sha1($subscription['name'])) ?>" alt="Channel Image">              
                                <div id="channelDescription">
                                    <h1>Description:</h1><p><?= $subscription['description'] ?></p>
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