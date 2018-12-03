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