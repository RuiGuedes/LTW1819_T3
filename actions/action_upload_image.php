<?php
    include_once('../includes/session.php');
    include_once('../database/db_user.php');
    include_once('../database/db_channel.php');

    // Get image ID
    $id = isset($_POST['imageID']) ? $_POST['imageID'] : die(header("Location: ../pages/feed.php"));

    // Determine if it's channel/profile valid image  
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
?>