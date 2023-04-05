console.log('hello Expo')

const container = document.querySelector('.email_container')
const formEmail = document.querySelector('.form_email_container')
const inputEmail = document.querySelector('.input_email')

const divSucces = document.createElement('p')
divSucces.setAttribute('class', 'succes')

formEmail.addEventListener('submit', (e) => {
    e.preventDefault()
    const emailValue = inputEmail.value.trim()
    divSucces.innerText = "Merci, j'ai bien reçu votre email !"
    container.insertAdjacentElement('afterend', divSucces)
    container.remove()
})