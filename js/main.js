'use strict'

//Channel referencing - Articles
let subscription = document.getElementsByClassName('subscriptionArticle')

for (let index = 0; index < subscription.length; index++) {
  subscription[index].addEventListener('click', function() {
        let submit = document.getElementById('submitChannelName')
        submit.value = subscription[index].id
        submit.click()
  })
}

//Channel referencing - Aside
let asideChannel = document.getElementsByClassName('asideChannelList')

for (let index = 0; index < asideChannel.length; index++) {
  asideChannel[index].addEventListener('click', function() {
        let submit = document.getElementById('submitAsideChannelName')
        submit.value = asideChannel[index].id
        submit.click()
  })
}

// Filter control
let filter = document.getElementById('filterID')

filter.addEventListener('change', function() {  
  filter.parentElement.submit()
})

// Channel / User description
let description = document.getElementById('description')
let editDescriptionButton = document.getElementById('editDescription')

let editDescriptionHandler = function() {
  let previousContent = document.getElementById('descriptionContent').innerHTML
  let previousHTML = description.innerHTML

  editDescriptionButton.outerHTML = '<button id="applyDescription" type="button"><i class="fas fa-check"></i></button>'
  document.getElementById('descriptionContent').outerHTML = 
    '<textarea id="descriptionContent" maxlength="240" cols="55" rows="1" placeholder="Short Description">' +
      previousContent + 
    '</textarea>'

  let applyDescriptionButton = document.getElementById('applyDescription')
  applyDescriptionButton.addEventListener('click', function() {
    let newContent = document.getElementById('descriptionContent').value

    let userName = document.getElementById('username')
    let channelName = document.getElementById('channelName')

    let request = new XMLHttpRequest()
    request.open("post", "../api/api_edit_description.php", true)
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    request.addEventListener('load', function() {
      newContent = JSON.parse(request.responseText)
      description.innerHTML = previousHTML
      document.getElementById('descriptionContent').innerHTML = newContent

      editDescriptionButton = document.getElementById('editDescription')
      editDescriptionButton.addEventListener('click', editDescriptionHandler)
    })
    if (userName) request.send(encodeForAjax({username: userName.textContent, description: newContent}))
    else          request.send(encodeForAjax({channelname: channelName.textContent, description: newContent}))
  })
}

if (editDescriptionButton !== null) {
  editDescriptionButton.addEventListener('click', editDescriptionHandler)
}

// Subscribe/Unsubscribe
let subscribeButton = document.getElementById('subscribeButton')

let subscriptionHandler = function() {
    let statistics = document.getElementsByClassName('statistics')
    let value = subscribeButton.value
    let followers = Number(statistics[2].innerHTML.match('[0-9]\+')[0])
  
    if (value == 'Subscribe') {
      followers++
      value = 'Unsubscribe'
    }
    else {
      followers--
      value = 'Subscribe'
    }

    let request = new XMLHttpRequest()  
    let userName = document.getElementById('user-name').textContent
    let channelname = document.getElementById('channelName').textContent

    request.open("post", "../api/api_subscribe_channel.php", true)
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    request.send(encodeForAjax({username: userName, channelName: channelname}))

    subscribeButton.value = value
    statistics[2].innerHTML = '<i class="fas fa-users"></i><p>' + followers + ' Followers</p>'
}

if (subscribeButton !== null)
  subscribeButton.addEventListener('click', subscriptionHandler)

// Vote up/down
let voteUp = document.getElementsByClassName('fas fa-chevron-up')
let voteDown = document.getElementsByClassName('fas fa-chevron-down')
let votesLength = voteDown.length

for(let index = 0; index < votesLength; index++) {
  let storyID = Number(voteDown[index].parentElement.parentElement.parentElement.parentElement.id.match('[0-9]\+')[0])
  let voteType = voteDown[index].parentElement.parentElement.parentElement.parentElement.id.match('story|comment')[0]
  
  voteDown[index].addEventListener('click', function() {voteHandler(storyID, voteType, -1)})
  voteUp[index].addEventListener('click', function() {voteHandler(storyID, voteType, 1)})
}

function voteHandler(storyID, voteType, type) {
  if(voteType == 'comment'){
    console.log("comment shit")
    return
  }

  let request = new XMLHttpRequest()  
  let userName = document.getElementById('user-name').textContent
  
  request.open("post", "../api/api_votes.php", true)
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
  request.addEventListener('load', () => {
    let votes = JSON.parse(request.responseText)
    let regex = document.getElementById("story_" + storyID + "_votes").childNodes[1].childNodes[1].innerHTML
    
    document.getElementById("story_" + storyID + "_votes").childNodes[1].childNodes[1].innerHTML = getVoteInnerHTML(type, regex, votes)
  
    let newVoteDown = document.getElementById("story_" + storyID + "_votes").getElementsByClassName('fas fa-chevron-down')
    let newVoteUp = document.getElementById("story_" + storyID + "_votes").getElementsByClassName('fas fa-chevron-up')

    newVoteDown[0].addEventListener('click', function() {voteHandler(storyID, -1)})
    newVoteUp[0].addEventListener('click', function() {voteHandler(storyID, 1)})
  })
  request.send(encodeForAjax({username: userName, storyid: storyID, voteType: type}))
}

// Retrieves vote new inner html
function getVoteInnerHTML(type, regex, votes) {
  if((type == 1 && regex.match('voteUp') !== null) || (type == -1 && regex.match('voteDown') !== null)) {
    return '<div> <i class="fas fa-chevron-up"></i> <i class="fas fa-chevron-down"></i> </div> <span class="storyVotes">' + votes + '</span>'
  }
  else if(type == 1) {
    return '<div> <i id="voteUp" class="fas fa-chevron-up"></i> <i class="fas fa-chevron-down"></i> </div> <span class="storyVotes">' + votes + '</span>'
  }
  else {
    return '<div> <i class="fas fa-chevron-up"></i> <i id="voteDown" class="fas fa-chevron-down"></i> </div> <span class="storyVotes">' + votes + '</span>'
  }
}

// Uploads image
let currPicture = document.getElementById('asidePicture')
let uploader = document.getElementById('uploadImage')
let postUploader = document.getElementById('uploadStoryPic')
let submit = document.getElementById('submitImage')

if(currPicture != null) {
  currPicture.addEventListener('click', function() {
    uploader.click()
  })
}

if(postUploader != null) {
  postUploader.addEventListener('click', function() {
    uploader.click();
  })
}

if(uploader != null) {
  uploader.addEventListener('change', function() {
    submit.click()
  })
}

// Story referencing 
let story = document.getElementsByClassName('storyArticle')

for (let index = 0; index < story.length; index++) {
  story[index].addEventListener('click', function(event) {
    
      if(event.target.tagName !== 'I') {
        let submit = document.getElementById('submitStoryForm')
        submit.value = story[index].id
        submit.click()
      }
  })
}

// Comment another comment and expand comments
let commentsReply = document.getElementsByClassName('reply')
let commentsExpand = document.getElementsByClassName('expand')

for(let index = 0; index < commentsReply.length; index++) {
  commentsReply[index].addEventListener('click', function() {
    commentReplyHandler(commentsReply[index])
  })
  commentsExpand[index].addEventListener('click', function() {
    commentExapndHandler(commentsExpand[index])
  })
}

function commentReplyHandler(commentSection) {
  // Variables
  let parent_id
  let root = commentSection
  let previousRoot = root

  // Retrieve root comment
  for(let i = 1; i <= 5; i++) {
    if(i == 3) {
      parent_id = Number(root.id.match('[0-9]\+')[0])
    }
    root = root.parentElement
  }
  
  // In case of hitting reply again
  if(root.getElementsByTagName('form').length > 0) {
    root.getElementsByTagName('form')[0].remove()
    return
  }

  // If needed alter text area position
  remove_comment_text_area()

  // Allow user to comment a specific comment
  let textArea = '<form id="newCommentTextArea"> <textarea name="" cols="30" rows="10" placeholder="Write your comment here ..."></textarea> <input type="submit" name="storyID" value="Comment"></form>'
  root.innerHTML += textArea

  reset_comment_buttons_class(root)

  let submit = document.getElementById('newCommentTextArea').getElementsByTagName('input')[0]
  submit.addEventListener('click', function(event) {
    event.preventDefault()

    // New comment variables
    let comment_content = document.getElementById('newCommentTextArea').getElementsByTagName('textarea')[0].value
    let story_id = document.getElementById('stories').childNodes[1].id

    if(comment_content == '')
      return;

    // Ajax
    let request = new XMLHttpRequest() 
    request.open("post", "../api/api_comments_reply.php", true)
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    request.addEventListener('load', () => {
      let newComment = JSON.parse(request.responseText)
      previousRoot.innerHTML += root.innerHTML +=  retrieve_child_comment(newComment)
      
      reset_comment_buttons_class(root)
      remove_comment_text_area()
    })
    request.send(encodeForAjax({commentContent: comment_content, storyID: story_id, parentID: parent_id}))
  })
}

function commentExapndHandler(commentSection) {
  // Retrieve root comment
  let parent_id
  let root = commentSection
  for(let i = 1; i <= 5; i++) {
    if(i == 3) {
      parent_id = Number(root.id.match('[0-9]\+')[0])
    }
    root = root.parentElement
  }

  // Remove comment text area if it's being displayed
  remove_comment_text_area()

  // Remove child comments from being displayed on screen
  if(root.getElementsByClassName('childComment').length > 0) {
    root.innerHTML = root.getElementsByTagName('article')[0].outerHTML
    reset_comment_buttons_class(root)
    return
  }

  // Ajax - Expand comment section
  let request = new XMLHttpRequest() 
  request.open("post", "../api/api_comments_expand.php", true)
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
  request.addEventListener('load', () => {
    let comments = JSON.parse(request.responseText)
    if(comments.length == 0)
      return

    for(let index = 0; index < comments.length; index++) {      
      root.innerHTML +=  retrieve_child_comment(comments[index])
    }
    
    reset_comment_buttons_class(root)
  })
  request.send(encodeForAjax({parentID: parent_id}))
}

function remove_comment_text_area() {
  let areas = document.getElementById("newCommentTextArea")
      if(areas != null)
        areas.remove()
}

function reset_comment_buttons_class(root) {
  let replyClass = root.getElementsByClassName('reply')
  for(let index = 0; index < replyClass.length; index++) {
      replyClass[index].addEventListener('click', function() {
        commentReplyHandler(replyClass[index])
    })
  }

  let expandClass = root.getElementsByClassName('expand')
  for(let index = 0; index < expandClass.length; index++) {
        expandClass[index].addEventListener('click', function() {
        commentExapndHandler(expandClass[index])
    })
  }
}

function retrieve_child_comment(comment) {
  let newChild = '<div class="childComment"><article><header><div id="comment_' + comment['commentID'] + '_votes">'
  newChild += '<div><div><div><i class="fas fa-chevron-up"></i><i class="fas fa-chevron-down"></i></div><span class="storyVotes">' + comment['commentPoints'] 
  newChild += '</span></div><span class="author"><i class="far fa-user"></i>' + comment['commentAuthor']
  newChild += '</span></div><div><span class="reply"><i class="fas fa-reply"></i></i>Reply</span><span class="expand"><i class="fas fa-stream"></i></i>Expand</span><span class="date">'
  newChild += '<i class="far fa-clock"></i>' + comment['commentTime'] + '</span></div></div></header> <p>' + comment['commentContent'] + '</p></article>'

  return newChild
}

function encodeForAjax(data) {
  return Object.keys(data).map(function(k){
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&')
} 