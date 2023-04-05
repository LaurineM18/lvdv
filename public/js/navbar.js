const burgerIcon = document.querySelector('#burgerIcon')
const closeIcon = document.querySelector('#closeIcon')

const modal = document.querySelector('.modal')

burgerIcon.addEventListener('click', () => {
    modal.classList.toggle('hidden')
    burgerIcon.classList.toggle('hidden')
    closeIcon.classList.toggle('hidden')
})

closeIcon.addEventListener('click', () => {
    modal.classList.toggle('hidden')
    burgerIcon.classList.toggle('hidden')
    closeIcon.classList.toggle('hidden')
})