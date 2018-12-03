<?php function draw_stories($stories, $storiesVotes) {
    /* Function responsible for drawing stories */
    foreach($stories as $story) { ?> 
        <article>
            <header id="storyHeader">
                <div>
                    <div>
                    <a class="votes"><i class="fas fa-minus-circle"></i><?= htmlentities($storiesVotes[$story['storyID']]) ?><i class="fas fa-plus-circle"></i></a>
                    <h3><?= htmlentities($story['channelName']) ?></h3>
                </div>
                <div>
                    <span class="author"><i class="fas fa-user-alt"></i><?= htmlentities($story['storyAuthor']) ?></span>
                    <a class="comments"><i class="fas fa-comments"></i><?= htmlentities($story['storyComments']) ?></a>
                    <span class="date"><i class="fas fa-clock"></i><?= htmlentities(data_converter($story['storyTime'])) ?></span>
                </div>
                </div>
                <div>
                    <img src="../resources/images/thumb.jpg" alt="Story Image">
                    <h1><?= htmlentities($story['storyTitle']) ?></h1>
                </div>
            </header>
            <div id="storySinopse">
                <p><?= htmlentities($story['storyContent']) ?></p>
            </div>
        </article>
    <?php } 
}
?>

<?php function orderBy($value) {
    /* Convert filter elements to their respective value */
    switch($value) {
    case 0:
        return 'storyPoints DESC';
    break;
    case 1:
        return 'storyPoints ASC';
    break;
    case 3:
        return 'storyID ASC';
    break;
    default:        
        return 'storyID DESC';
    break;
    }
}
?>

<?php function data_converter($storyTime) {
    /* Converts time in order to be properly displayed */
    $newStoryTime = new DateTime(date('Y-m-d H:i:s'));
    $oldStoryTime = new DateTime($storyTime);

    $interval = date_diff($newStoryTime, $oldStoryTime);

    if($interval->format('%y') !== '0')
        return $interval->format('%y Year');
    else if($interval->format('%m') !== '0')
        return $interval->format('%m Month');
    else if($interval->format('%d') !== '0')
        return $interval->format('%d Day');
    else if($interval->format('%h') !== '0')
        return $interval->format('%h Hour');
    else if($interval->format('%i') !== '0')
        return $interval->format('%i Min');
    else 
        return $interval->format('%s Sec');
}
?> 