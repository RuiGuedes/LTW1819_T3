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

// Votes /* TODO - Ajax to alter votes */
let votesDown = document.getElementsByClassName('fas fa-minus-circle')
let votesUp = document.getElementsByClassName('fas fa-plus-circle')
let votesLength = votesDown.length

for (let index = 0; index < votesLength; index++) {
  votesDown[index].addEventListener('click', function() {
    
  })

  votesUp[index].addEventListener('click', function() {
    
  })
}

//Channel referencing
let subscription = document.getElementsByClassName('subscriptionArticle')

for (let index = 0; index < subscription.length; index++) {
  subscription[index].addEventListener('click', function() {
        let submit = document.getElementById('submitChannelName')
        submit.value = subscription[index].id
        submit.click()
  })
}

// Filter control
let filter = document.getElementById('filterID')

filter.addEventListener('change', function() {  
  console.log(filter.value)
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
    let userName = document.getElementById('user-name').textContent

    let request = new XMLHttpRequest()
    request.open("post", "../api/api_edit_description.php", true)
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    request.addEventListener('load', () => newContent = JSON.parse(request.responseText))
    request.send(encodeForAjax({username: userName, description: newContent}))
  
    description.innerHTML = previousHTML
    document.getElementById('descriptionContent').innerHTML = newContent

    editDescriptionButton = document.getElementById('editDescription')
    editDescriptionButton.addEventListener('click', editDescriptionHandler)
  })
}

if(editDescriptionButton !== null)
  editDescriptionButton.addEventListener('click', editDescriptionHandler)

// Subscribe/Unsubscribe
let subscribeButton = document.getElementById('subscribeButton')

let subscriptionHandler = function() {
    let statistics = document.getElementsByClassName('statistics')
    let value = subscribeButton.value
    let followers = Number(statistics[1].innerHTML.match('[0-9]\+')[0])

    if(value == 'Subscribe') {
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
    statistics[1].innerHTML = '<i class="fas fa-users"></i><p>' + followers + ' Followers</p>'
}

if(subscribeButton !== null)
  subscribeButton.addEventListener('click', subscriptionHandler)

function encodeForAjax(data) {
  return Object.keys(data).map(function(k){
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&')
} 