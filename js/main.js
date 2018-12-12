'use strict'

// Story referencing 
let story = document.getElementsByClassName('storyArticle')

for (let index = 0; index < story.length; index++) {
  story[index].addEventListener('click', function(event) {
      if(event.target.tagName !== 'I') {
        let submit = document.getElementById('submitForm')
        submit.value = story[index].id
        submit.click()
      }
  })
}

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

if (editDescriptionButton !== null)
  editDescriptionButton.addEventListener('click', editDescriptionHandler)

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
    let storyID = voteDown[index].parentElement.id
    voteDown[index].addEventListener('click', function() {voteHandler(storyID, -1)})
    voteUp[index].addEventListener('click', function() {voteHandler(storyID, 1)})
}

function voteHandler(storyID, type) {
  let request = new XMLHttpRequest()  
  let userName = document.getElementById('user-name').textContent
  
  request.open("post", "../api/api_votes.php", true)
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
  request.addEventListener('load', () => {
    let votes = JSON.parse(request.responseText)
    let regex = document.getElementById(storyID).innerHTML
    
    document.getElementById(storyID).innerHTML = getVoteInnerHTML(type, regex, votes)
    
    let newVoteDown = document.getElementById(storyID).getElementsByClassName('fas fa-chevron-down')
    let newVoteUp = document.getElementById(storyID).getElementsByClassName('fas fa-chevron-up')

    newVoteDown[0].addEventListener('click', function() {voteHandler(storyID, -1)})
    newVoteUp[0].addEventListener('click', function() {voteHandler(storyID, 1)})
  })
  request.send(encodeForAjax({username: userName, storyid: storyID, voteType: type}))
}

// Retrieves vote new inner html
function getVoteInnerHTML(type, regex, votes) {
  if((type == 1 && regex.match('voteUp') !== null) || (type == -1 && regex.match('voteDown') !== null)) {
    return '<i class="fas fa-chevron-up"></i><span class="storyVotes">' + votes + '</span><i class="fas fa-chevron-down"></i>'
  }
  else if(type == 1 && regex.match('voteDown') !== null) {
    return '<i id="voteUp"class="fas fa-chevron-up"></i><span class="storyVotes">' + votes + '</span><i class="fas fa-chevron-down"></i>'
  }
  else if(type == -1 && regex.match('voteUp') !== null) {
    return '<i class="fas fa-chevron-up"></i><span class="storyVotes">' + votes + '</span><i id="voteDown" class="fas fa-chevron-down"></i>'
  }
  else if(type == 1) {
    return '<i id="voteUp" class="fas fa-chevron-up"></i><span class="storyVotes">' + votes + '</span><i class="fas fa-chevron-down"></i>'
  }
  else {
    return '<i class="fas fa-chevron-up"></i><span class="storyVotes">' + votes + '</span><i id="voteDown" class="fas fa-chevron-down"></i>'
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

uploader.addEventListener('change', function() {
  submit.click()
})

function encodeForAjax(data) {
  return Object.keys(data).map(function(k){
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&')
} 