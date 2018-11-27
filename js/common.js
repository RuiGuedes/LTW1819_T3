'use strict'

// Filter control
let filter = document.getElementById('filterID')

filter.addEventListener('change', function() {
  filter.parentElement.submit()
})

// Channel / User description
let description = document.getElementById('description')
let editDescriptionButton = document.getElementById('editDescription')
let applyDescriptionButton;

let editDescriptionHandler = function() {
  let previousHTML = description.innerHTML

  editDescriptionButton.outerHTML = '<button id="applyDescription" type="button"><i class="fas fa-check"></i></button>' +
                                    '<textarea id="descriptionContent" maxlength="240" cols="55" rows="1" placeholder="Short Description"></textarea>'

  applyDescriptionButton = document.getElementById('applyDescription')
  applyDescriptionButton.addEventListener('click', function() {
    // TODO AJAX to send the new bio to the server and update the current HTML with the new bio
  
    description.innerHTML = previousHTML;
    editDescriptionButton = document.getElementById('editDescription')
    editDescriptionButton.addEventListener('click', editDescriptionHandler);
  })
}

editDescriptionButton.addEventListener('click', editDescriptionHandler)