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