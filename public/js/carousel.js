class Carousel {

    /**
     * 
     * @param {HTMLElement} element 
     * @param {object} options 
     * @param {object} options.slidesToScroll nb d'éléments à faire défiler 
     * @param {object} options.slidesVisible nb d'éléments visibles
     */
    constructor (element, options = {}) {
        this.element = element
        this.options = Object.assign({}, {
            slidesToScroll: 1,
            slidesVisible:1
        }, options)

       let children = [].slice.call(element.children)
       this.currentItem = 0
       this.isMobile = false

       //Modification du DOM
        let root = this.createElement('div', {'class': 'carousel', "tabindex": '0'})
        this.panorama = this.createElement('div', {'class': 'panorama'})
        root.append(this.panorama)
        this.element.append(root)
        this.items = children.map(child => {
            let item = this.createElement('div', {'class': 'carousel-item'})
            item.append(child)
            this.panorama.append(item)
            return item
        })

        this.setStyle()

        let nextButton = document.querySelector('.carousel-next');
        let previousButton = document.querySelector('.carousel-previous');
        root.append(nextButton)
        root.append(previousButton)
        nextButton.addEventListener("click", this.next.bind(this)) //utilisation fonction next au clic. bind permet de garder le this
        previousButton.addEventListener("click", this.previous.bind(this))

        //Evenements
        this.onWindowResize()
        window.addEventListener('resize', this.onWindowResize.bind(this))
        root.addEventListener("keyup", e => {   
            if (e.key === 'ArrowRight'){
                this.next()
            } else if (e.key === 'ArrowLeft'){
                this.previous()
            }
        })
    }


    //fonction pour le bouton next
    next() {
        this.goToItem(this.currentItem + this.slidesVisible)
    }

    //fonction pour le bouton previous
    previous() {
        this.goToItem(this.currentItem - this.slidesVisible)

    }

    /**
     * Déplace le carousel vers l'élément ciblé
     * @param {number} index 
     */
    goToItem(index) {
        if(index < 0){
            index = this.items.length - this.slidesVisible
        }else if (index >= this.items.length) {
            index = 0
        }
        let translateX = index * -100 / this.items.length
        this.panorama.style.transform = 'translate3d(' + translateX + '%,0,0)'
        this.currentItem = index
    }

    /**
     * 
     * @param {string} tagName 
     * @param {object} attributes 
     * @returns {HTMLElement}
     */
    createElement(tagName, attributes = {}) {
        const element = document.createElement(tagName)
        //Parcourir un objet de clés et valeurs
        for (const [attribute, value] of Object.entries(attributes)){
            if(value !== null){
                element.setAttribute(attribute, value)
            }
        }
        return element
    }


    /**
     * Fonction qui permet de définir la taille des items dans le carousel
     */
    setStyle () {
        let ratio = this.items.length / this.slidesVisible
        this.panorama.style.width = (ratio * 100) + "%"
        this.items.forEach(item => {
            item.style.width = (100/ this.slidesVisible) / ratio + "%"
        })
    }

    /**
     * Pour définir si on est sur mobile
     */
    onWindowResize() {
        let mobile = window.innerWidth < 800
        if (mobile !== this.isMobile){
            this.isMobile = mobile
            this.setStyle()
        }
    }

    /**
     * Définit le nombre d'item à faire défiler selon ordi ou mobile
     * @returns {number}
     */
    get slidesToScroll () {
        return this.isMobile ? 1 : this.options.slidesToScroll
    }

    /**
     * Définit le nombre d'item visibles selon ordi ou mobile
     * @returns {number}
     */
    get slidesVisible () {
        return this.isMobile ? 1 : this.options.slidesVisible

    }
}

const element = document.querySelector('.carousel_container')

new Carousel(element, {

})