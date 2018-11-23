'use strict'

/* Not made yet - This file is meant to be responsible for enable and disable textares throughout a button. Any doubts ask Rui Guedes */

let biography = document.getElementById('biographyContent')
biography.addEventListener('mouseover', showMenu)
biography.addEventListener('mouseout', hideMenu)

function showMenu() {
    biography.disabled = 'true'
}

function hideMenu() {
    biography.disabled = 'false'
}