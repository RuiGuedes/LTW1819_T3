<?php
    include_once('../includes/session.php');
    include_once('../database/db_user.php');
    include_once('../database/db_channel.php');

    // Get image ID
    $id = isset($_POST['imageID']) ? $_POST['imageID'] : die(header("Location: ../pages/feed.php"));

    // Determine if it's channel/profile valid image  
    $imgInfo['directory'] = '../resources/images/';
    $imgInfo['availableExtensions'] = ['jpg', 'png', 'gif'];
    if(check_user_existence($id)) {
        $imgInfo['type'] = 'profile';
        $imgInfo['directory'] = '../resources/images/users/';
        $imgInfo['extension'] = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    }
    else if(check_channel_existence($id)) {
        $imgInfo['type'] = 'channel';
        $imgInfo['directory'] = '../resources/images/channels/';
        $imgInfo['extension'] = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    }
    else if(check_story_existence($id)) {
        $imgInfo['type'] = 'story';
        $imgInfo['directory'] = '../resources/images/stories/';
        $imgInfo['extension'] = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    }
    else {
        die(header("Location: ../pages/feed.php"));
    }

    // Check if file extension is valid
    if($imgInfo['extension'] !== 'jpg' && $imgInfo['extension'] !== 'png' && $imgInfo['extension'] !== 'gif') {
        $_SESSION['messages'][] = array('type' => 'error', 'content' => 'File extension not valid. Available extensions: <jpg> <png> <gif> !');
        die(header('Location: ../pages/profile.php?username=' . $_SESSION['username']));
    }

    // Delete previous image if exists
    if(file_exists($imgInfo['directory'] . $id . '.' . 'jpg')) {
        unlink($imgInfo['directory'] . $id . '.' . 'jpg');
    }
    
    if(file_exists($imgInfo['directory'] . $id . '.' . 'png')) {
        unlink($imgInfo['directory'] . $id . '.' . 'png');
    }
    
    if(file_exists($imgInfo['directory'] . $id . '.' . 'gif')) {
        unlink($imgInfo['directory'] . $id . '.' . 'gif');
    }

    // Generate filenames for original
    $originalFileName = $imgInfo['directory'] . $id . '.' . $imgInfo['extension'];    

    // Move the uploaded file to its final destination
    move_uploaded_file($_FILES['image']['tmp_name'], $originalFileName);

    if($imgInfo['extension'] == 'jpg') {
        imagecreatefromjpeg($originalFileName);
    }
    else if($imgInfo['extension'] == 'png') {
        imagecreatefrompng($originalFileName);
    }
    else if($imgInfo['extension'] == 'gif') {
        imagecreatefromgif($originalFileName);
    }   

    if($imgInfo['type'] == 'profile') {
        die(header('Location: ../pages/profile.php?username=' . $id));
    }
    else if($imgInfo['type'] == 'channel') {
        die(header('Location: ../pages/channel.php?channelName=' . $id));
    }
    else if($imgInfo['type'] == 'story') {
        die(header('Location: ../pages/post.php?storyID=' . $id));
    }

    /* $smallFileName = "../resourcesimages/thumbs_small/$id.jpg";
    $mediumFileName = "../resourcesimages/thumbs_medium/$id.jpg"; */

    /* $width = imagesx($original);     // width of the original image
    $height = imagesy($original);    // height of the original image
    $square = min($width, $height);  // size length of the maximum square

    

    // Create and save a small square thumbnail
    $small = imagecreatetruecolor(200, 200);
    imagecopyresized($small, $original, 0, 0, ($width>$square)?($width-$square)/2:0, ($height>$square)?($height-$square)/2:0, 200, 200, $square, $square);
    imagejpeg($small, $smallFileName);

    // Calculate width and height of medium sized image (max width: 400)
    $mediumwidth = $width;
    $mediumheight = $height;
    if ($mediumwidth > 400) {
        $mediumwidth = 400;
        $mediumheight = $mediumheight * ( $mediumwidth / $width );
    }

    // Create and save a medium image
    $medium = imagecreatetruecolor($mediumwidth, $mediumheight);
    imagecopyresized($medium, $original, 0, 0, 0, 0, $mediumwidth, $mediumheight, $width, $height);
    imagejpeg($medium, $mediumFileName); */

    /* header("Location: index.php"); */
?>