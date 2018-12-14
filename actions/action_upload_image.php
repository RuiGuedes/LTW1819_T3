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
    if(!in_array($imgInfo['extension'], $imgInfo['availableExtensions'])) {
        $_SESSION['messages'][] = array('type' => 'error', 'content' => "File extension not valid. Available extensions: ." . implode(" .", $imgInfo['availableExtensions']) . " !");
        die(header('Location: ../pages/profile.php?username=' . $_SESSION['username']));
    }

    // Delete previous image if exists
    for($index = 0; $index < count($imgInfo['availableExtensions']); $index++) {
        if(file_exists($imgInfo['directory'] . sha1($id) . '.' . $imgInfo['availableExtensions'][$index])) {
            unlink($imgInfo['directory'] . sha1($id) . '.' . $imgInfo['availableExtensions'][$index]);
        }
    }

    // Generate filenames for original
    $originalFileName = $imgInfo['directory'] . sha1($id) . '.' . $imgInfo['extension'];    

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