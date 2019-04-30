import Glide from '@glidejs/glide'
import { getOffsetElement } from '../component/position';

class BookTabs {
    slider;

    constructor() {
        this.slider = new Glide('#book-slider');
        this.initActions();
        this.showSlider();
    };

    /**
     * Allows to initialize actions.
     */
    initActions() {
        document
            .querySelector('#book-tabs [data-tab="tab-slider"]:not([disabled]')
            .addEventListener('click', () => { this.showSlider(); })
        ;
        document
            .querySelector('#book-tabs [data-tab="tab-videos"]:not([disabled]')
            .addEventListener('click', () => { this.showVideos(); })
        ;
        document.getElementById('center-button').addEventListener('click', () => {
            const offset = getOffsetElement(document.getElementById('book-slider'));
            window.scroll({
                top: offset.top,
                left: offset.left,
                behavior: 'smooth'
            });
        });
    };

    /**
     * Display slider tab.
     */
    showSlider() {
        document.getElementById('tab-videos').classList.remove('active');
        document.getElementById('tab-slider').classList.add('active');
        this.slider.mount();
    };

    /**
     * Display videos tab.
     */
    showVideos() {
        document.getElementById('tab-slider').classList.remove('active');
        document.getElementById('tab-videos').classList.add('active');
        this.slider.destroy();
    };
}

const initBookTabs = () => {
    new BookTabs();
};

document.getElementById('book-tabs') && initBookTabs();
