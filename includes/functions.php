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
    case 4:
        return 'storyComments DESC';
    break;
    case 5:
        return 'storyComments ASC';
    break;
    default:        
        return 'storyID DESC';
    break;
    }
}

function search_query_converter($value) {
    /* Convert search filter elements to their respective value */
    switch($value) {
    case 0:
        return 'channelName';
    break;
    case 1:
        return 'storyAuthor';
    break;
    default:
        return 'storyTitle';
    break;
    }
}

function data_converter($storyTime) {
    /* Converts time in order to be properly displayed */
    $newStoryTime = new DateTime(date('Y-m-d H:i:s'));
    $oldStoryTime = new DateTime($storyTime);

    $interval = date_diff($newStoryTime, $oldStoryTime);

    if($interval->format('%y') !== '0')
        return $interval->format('%y Y');
    else if($interval->format('%m') !== '0')
        return $interval->format('%m M');
    else if($interval->format('%d') !== '0')
        return $interval->format('%d d');
    else if($interval->format('%h') !== '0')
        return $interval->format('%h h');
    else if($interval->format('%i') !== '0')
        return $interval->format('%i m');
    else 
        return $interval->format('%s s');
}

function htmlentities_all($data) {
    /* Applies htmlentities to every element on data */
    foreach($data as $k => $v) {
        switch(gettype($v)) {
            case 'array':
                $data[$k] = htmlentities_all($v);        
                break;
            case 'string':
                $data[$k] = htmlentities($v);        
                break;
        }
    }
    return $data;
}
?> 

<?php function get_image($default, $directory, $folder, $element) {
    /* Retrieves image relative to a certain element */
    $image = $default;
    $extensions = ['jpg', 'png', 'gif'];

    for($index = 0; $index < count($extensions); $index++) {
        if(file_exists($directory . $element . '.' . $extensions[$index])) {
            $image = $folder . $element . '.' . $extensions[$index];
            break;
        }
    }
    return $image;
} ?>
