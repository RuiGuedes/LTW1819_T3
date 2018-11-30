'use strict'

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
    let userName = document.getElementById('username').textContent

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

editDescriptionButton.addEventListener('click', editDescriptionHandler)

function encodeForAjax(data) {
  return Object.keys(data).map(function(k){
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&')
} 