import Glider from 'glider-js'

const initBookGlider = () => {
    const booksGlider = new Glider(document.getElementById('book-glider'), {
        draggable: true,
        slidesToShow: 1,
        arrows: {
            prev: '.glider-prev',
            next: '.glider-next'
        },
        responsive: [
            {
                breakpoint: 1216,
                settings: {
                    slidesToShow: 3,
                }
            }
        ]
    });
}

document.getElementById('book-glider') && initBookGlider();
