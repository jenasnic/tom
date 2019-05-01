import Glide from '@glidejs/glide'
import { getOffsetElement } from '../component/position';

class BookTabs {
    glider;
    sliderTab;
    videosTab;

    constructor() {
        this.sliderTab = document.getElementById('tab-slider');
        this.videosTab = document.getElementById('tab-videos');

        this.initActions();

        if (this.sliderTab) {
            this.showSlider();
        } else if (this.videosTab) {
            this.showVideos();
        }
    };

    /**
     * Allows to initialize actions.
     */
    initActions() {
        if (this.sliderTab) {
            document.querySelector('#book-tabs [data-tab="tab-slider"]').addEventListener(
                    'click',
                    () => { this.showSlider(); }
            );

            this.glider = new Glide('#book-slider');

            document.getElementById('center-button') && document.getElementById('center-button').addEventListener('click', () => {
                const offset = getOffsetElement(document.getElementById('book-slider'));
                window.scroll({
                    top: offset.top,
                    left: offset.left,
                    behavior: 'smooth'
                });
            });
        }

        if (this.videosTab) {
            document.querySelector('#book-tabs [data-tab="tab-videos"]').addEventListener(
                'click',
                () => { this.showVideos(); }
            );
        }
    };

    /**
     * Display slider tab.
     */
    showSlider() {
        this.videosTab && this.videosTab.classList.remove('active');
        this.sliderTab.classList.add('active');
        this.glider.mount();
    };

    /**
     * Display videos tab.
     */
    showVideos() {
        if (this.sliderTab) {
            this.sliderTab.classList.remove('active');
            this.glider.destroy();
        }
        this.videosTab.classList.add('active');
    };
}

const initBookTabs = () => {
    new BookTabs();
};

document.getElementById('book-tabs') && initBookTabs();
