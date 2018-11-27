'use strict'

let currPicture = document.getElementById('profileImg')
let uploader = document.getElementById('imgupload')
let submit = document.getElementById('imgsubmit')

currPicture.addEventListener('click', uploadFile)

function uploadFile() {
    uploader.click()
}

if(uploader.nodeValue != '') {
    submit.click()
}
