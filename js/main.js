'use strict'

//Channel referencing - Articles
let channel = document.getElementsByClassName('channelArticle')

for (let index = 0; index < channel.length; index++) {
  channel[index].addEventListener('click', function() {
        let submit = document.getElementById('submitChannelName')
        submit.value = channel[index].id
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

// Filter control - Search secondary filter retrieve
let filter = document.getElementById('filterID')
let searchForm = document.getElementById('searchFilterID').parentElement
let searchField = document.getElementById('searchField')

filter.addEventListener('change', function() {  
  filter.parentElement.submit()
})

searchField.onsearch = function(event){
  event.preventDefault()
  searchForm.getElementsByTagName('input')[0].value = filter.value
  searchForm.submit()
}

searchForm.addEventListener('submit', function(event) {
  event.preventDefault()
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
  let rootID = Number(voteDown[index].parentElement.parentElement.parentElement.parentElement.id.match('[0-9]\+')[0])
  let voteType = voteDown[index].parentElement.parentElement.parentElement.parentElement.id.match('story|comment')[0]

  voteDown[index].addEventListener('click', function() {voteHandler(rootID, voteType, -1)})
  voteUp[index].addEventListener('click', function() {voteHandler(rootID, voteType, 1)})
}

function voteHandler(rootID, voteType, type) {
  // Variables 
  let userName = document.getElementById('user-name').textContent

  // Ajax - Update vote status
  let request = new XMLHttpRequest()  
  request.open("post", "../api/api_" + voteType + "_votes.php", true)
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
  request.addEventListener('load', () => {
    let votes = JSON.parse(request.responseText)
    let regex = document.getElementById(voteType + "_" + rootID + "_votes").getElementsByClassName('votes')[0].innerHTML

    document.getElementById(voteType + "_" + rootID + "_votes").getElementsByClassName('votes')[0].innerHTML = getVoteInnerHTML(type, regex, votes)
  
    let newVoteDown = document.getElementById(voteType + "_" + rootID + "_votes").getElementsByClassName('fas fa-chevron-down')
    let newVoteUp = document.getElementById(voteType + "_" + rootID + "_votes").getElementsByClassName('fas fa-chevron-up')

    newVoteDown[0].addEventListener('click', function() {voteHandler(rootID, voteType, -1)})
    newVoteUp[0].addEventListener('click', function() {voteHandler(rootID, voteType, 1)})
  })
  request.send(encodeForAjax({username: userName, rootid: rootID, voteType: type}))
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
    if(postUploader != null) {
      postUploader.getElementsByTagName('p')[0].textContent = 'File uploaded'
    }
    if(submit != null)
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
    commentReplyHandler(commentsReply[index], index)
  })
  commentsExpand[index].addEventListener('click', function() {
    commentExpandHandler(commentsExpand[index])
  })
}

function commentReplyHandler(commentSection, index) {
  // Variables
  let parent_id
  let root = commentSection
  let storyNumComments = Number(document.getElementsByClassName('comments')[0].childNodes[1].textContent)

  // Retrieve root comment
  for(let i = 1; i <= 5; i++) {
    if(i == 3) {
      parent_id = Number(root.id.match('[0-9]\+')[0])
    }
    root = root.parentElement
  }

  // Remove story reply section
  let storyComment = document.getElementById('submitCommentForm').parentElement
  storyComment.style.visibility = 'hidden'
  
  // In case of hitting reply again
  if(root.getElementsByTagName('form').length > 0) {
    root.getElementsByTagName('form')[0].remove()
    storyComment.style.visibility = 'visible'
    return
  }

  // If needed alter text area position
  remove_comment_text_area()

  // Allow user to comment a specific comment
  let textArea = '<form id="newCommentTextArea"> <textarea name="" cols="30" rows="5" placeholder="Write your reply ..."></textarea> <input type="submit" name="storyID" value="Reply"></form>'
  root.innerHTML += textArea

  // Reset buttons due to a new html
  set_buttons_custom_listener(root)

  let submit = document.getElementById('newCommentTextArea').getElementsByTagName('input')[0]
  submit.addEventListener('click', function(event) {
    event.preventDefault()

    // New comment variables
    let comment_content = document.getElementById('newCommentTextArea').getElementsByTagName('textarea')[0].value
    let story_id = document.getElementById('stories').childNodes[1].id

    // Invalid comment - no content
    if(comment_content == '')
      return;


    // Ajax
    let request = new XMLHttpRequest() 
    request.open("post", "../api/api_comments_reply.php", true)
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    request.addEventListener('load', () => {
      document.getElementsByClassName('comments')[0].childNodes[1].textContent = storyNumComments + 1
      document.getElementsByClassName('expand')[index].click()

      set_buttons_custom_listener(root)
      remove_comment_text_area()
      storyComment.style.visibility = 'visible'
    })
    request.send(encodeForAjax({commentContent: comment_content, storyID: story_id, parentID: parent_id}))
  })
}

function commentExpandHandler(commentSection) {
  // Variables
  let parent_id
  let root = commentSection

  // Retrieve root comment
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
    set_buttons_custom_listener(root)
    return
  }

  let userName = document.getElementById('user-name').lastChild.textContent

  // Ajax - Expand comment section
  let request = new XMLHttpRequest() 
  request.open("post", "../api/api_comments_expand.php", true)
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
  request.addEventListener('load', () => {
    let response = JSON.parse(request.responseText)
    let comments = response[0]
    let votedComments = response[1]

    if(comments.length == 0)  
      return

    for(let index = 0; index < comments.length; index++) {      
      root.innerHTML +=  get_comment_html(comments[index], votedComments[comments[index]['commentID']])
    }
    
    set_buttons_custom_listener(root)
  })
  request.send(encodeForAjax({parentID: parent_id, username: userName}))
}

// Remove comment text area relative to another comment
function remove_comment_text_area() {
  let areas = document.getElementById("newCommentTextArea")
      if(areas != null)
        areas.remove()
}

// Resets comments buttons due to the presence of new html
function set_buttons_custom_listener(root) {
  let replyClass = root.getElementsByClassName('reply')
  for(let index = 0; index < replyClass.length; index++) {
      replyClass[index].addEventListener('click', function() {
        commentReplyHandler(replyClass[index], index)
    })
  }

  let expandClass = root.getElementsByClassName('expand')
  for(let index = 0; index < expandClass.length; index++) {
        expandClass[index].addEventListener('click', function() {
        commentExpandHandler(expandClass[index], index)
    })
  }

  let voteUpClass = root.getElementsByClassName('fas fa-chevron-up')
  let voteDownClass = root.getElementsByClassName('fas fa-chevron-down')
  let votesLengthClass = voteDownClass.length

  for(let index = 0; index < votesLengthClass; index++) {
    let storyID = Number(voteDownClass[index].parentElement.parentElement.parentElement.parentElement.id.match('[0-9]\+')[0])
    let voteType = voteDownClass[index].parentElement.parentElement.parentElement.parentElement.id.match('story|comment')[0]
    
    voteDownClass[index].addEventListener('click', function() {voteHandler(storyID, voteType, -1)})
    voteUpClass[index].addEventListener('click', function() {voteHandler(storyID, voteType, 1)})
  }
}

// Retrieve the html of certain comment
function get_comment_html(comment, voteType) {
  let newChild = '<div class="childComment"><article><header><div id="comment_' + comment['commentID'] + '_votes"><div><div class="votes"><div>'

  if(voteType == 1) {
    newChild += '<i id="voteUp" class="fas fa-chevron-up"></i><i class="fas fa-chevron-down"></i>'
  }
  else if(voteType == -1) {
    newChild += '<i class="fas fa-chevron-up"></i><i id="voteDown" class="fas fa-chevron-down"></i>'
  }
  else {
    newChild += '<i class="fas fa-chevron-up"></i><i class="fas fa-chevron-down"></i>'
  }

  newChild += '</div><span class="storyVotes">' + comment['commentPoints'] + '</span></div><span class="author"><i class="far fa-user"></i>' + comment['commentAuthor']
  newChild += '</span></div><div><span class="reply"><i class="fas fa-reply"></i></i>Reply</span><span class="expand"><i class="fas fa-stream"></i></i>Expand</span><span class="date">'
  newChild += '<i class="far fa-clock"></i>' + comment['commentTime'] + '</span></div></div></header> <p>' + comment['commentContent'] + '</p></article>'

  return newChild
}

function encodeForAjax(data) {
  return Object.keys(data).map(function(k){
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&')
} 