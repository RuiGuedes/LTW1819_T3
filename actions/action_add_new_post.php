<?php
    include_once('../includes/session.php');
    include_once('../database/db_user.php');
    include_once('../database/db_channel.php');
    include_once('../database/db_story.php');

    // Checks channel existence
    $channelName = isset($_POST['channelName']) ? $_POST['channelName'] : '';

    if(!check_channel_existence($channelName)) 
      die(header('Location: feed.php'));

    // Stores variables to be inserted on database
    $storyTitle = $_POST['title'];
    $storyContent = $_POST['content'];
    $storyAuthor = $_SESSION['username'];
    $storyTime = date('Y-m-d H:i:s');

    // Get last story ID and increment it to use it to store image ID
    $id = get_last_storyID() + 1;

    // Check if story has image. If it has add it
    if(!($_FILES['image']['tmp_name'] == null)) {
      add_story_image($id);
    }

    // Add's new story 
    add_new_story($storyTitle, $storyContent, $storyAuthor, $storyTime, $channelName);
    
    header('Location: ../pages/channel.php?channelName=' . $channelName);
?>

<?php  function add_story_image($id) {
  // Determine if it's channel/profile valid image  
  $imgInfo['availableExtensions'] = ['jpg', 'png', 'gif'];
  $imgInfo['type'] = 'story';
  $imgInfo['directory'] = '../resources/images/stories/';
  $imgInfo['extension'] = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

  // Check if file extension is valid
  if(!in_array($imgInfo['extension'], $imgInfo['availableExtensions'])) {
      generate_error("File extension not valid. Available extensions: <" . implode("> <", $imgInfo['availableExtensions']) . "> !"));
      die(header('Location: ../pages/channel.php?channelName=' . $channelName));
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
}
?>