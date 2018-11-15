'use strict'

let header = document.getElementById('header')
header.addEventListener('mouseover', showMenu)
header.addEventListener('mouseout', hideMenu)

let menu = document.getElementById('menu')
menu.addEventListener('mouseover', showMenu)
menu.addEventListener('mouseout', hideMenu)


function showMenu() {
    document.body.style.gridTemplateColumns = 'auto 5.5fr 2fr'
    document.body.style.gridTemplateRows = 'auto 100%' 

    header.lastElementChild.style.visibility = 'visible'

    let menuText = menu.getElementsByTagName('li');
    for(let i = 0; i < menuText.length; i++) {
        menuText[i].style.visibility = 'visible'
    }
}

function hideMenu() {
    document.body.style.gridTemplateColumns = '3.5em 5.5fr 2fr'
    document.body.style.gridTemplateRows = '4em 100%'

    header.lastElementChild.style.visibility = 'hidden'

    let menuText = menu.getElementsByTagName('li');
    for(let i = 0; i < menuText.length; i++) {
        menuText[i].style.visibility = 'hidden'
    }
}
