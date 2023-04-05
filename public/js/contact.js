
const formContact = document.querySelector('.form_container')
const lastname = document.querySelector('.input_name')
const firstname = document.querySelector('.input_firstname')
const mail = document.querySelector('.input_mail')
const object = document.querySelector('.input_object')
const message = document.querySelector('.textarea')


const divSucces = document.createElement('p')
divSucces.setAttribute('class', 'succes')

const divError = document.createElement('div')
divError.setAttribute('class', 'error')


lastname.addEventListener ('keyup', (e) => {
    const nameValue = lastname.value.trim()
    if (nameValue.length < 3) {
        divError.innerText = 'Nombre de caractères insuffisant.'
        lastname.insertAdjacentElement('afterend', divError)
    } else {
        divError.innerText = ""
    }
})

firstname.addEventListener ('keyup', (e) => {
    const firstnameValue = firstname.value.trim()
    if (firstnameValue < 2) {
        divError.innerText = 'Nombre de caractères insuffisant.'
        firstname.insertAdjacentElement('afterend', divError)
    } else {
        divError.innerText = ""
    }
})

/*formContact.addEventListener('submit', (e) => {
    e.preventDefault()
    const nameValue = lastname.value.trim()
    const firstnameValue = firstname.value.trim()
    const mailValue = mail.value.trim()
    const objectValue = object.value.trim()
    const messageValue = message.value.trim()
    if (nameValue.length < 3 || nameValue.length > 20) {
        divError.innerText = 'Nombre de caractères insuffisant.'
        lastname.insertAdjacentElement('afterend', divError)
    } else if (firstnameValue < 2) {
        divError.innerText = 'Nombre de caractères insuffisant.'
        firstname.insertAdjacentElement('afterend', divError)
    } else if (objectValue === '') {
        divError.innerText = 'Merci de mettre un objet.'
        object.insertAdjacentElement('afterend', divError)
    } else if (messageValue === '') {
        divError.innerText = 'Merci de laisser un message.'
        message.insertAdjacentElement('afterend', divError)
    } else {
        divSucces.innerText = 'Message bien envoyé !'
        formContact.insertAdjacentElement('afterend', divSucces)
    }


})*/


