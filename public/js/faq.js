const questions = document.querySelectorAll('.question');

questions.forEach(item => {
    item.addEventListener('click', function () {
        const next = item.nextElementSibling;
        next.classList.toggle('visible');

        icone = item.lastElementChild;
        icone.classList.toggle('chevron-up');

    });
});

