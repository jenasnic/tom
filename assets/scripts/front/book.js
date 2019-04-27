import Glide from '@glidejs/glide'
import { getOffsetElement } from '../component/position';

const initBookTabs = () => {
    initTabActions();
    document.getElementById('book-slider') && initSlider();
}

const initTabActions = () => {
    [...document.querySelectorAll('#book-tabs [data-tab]:not([disabled])')].forEach(
        (element) => {
            element.addEventListener('click', () => {switchTab(element.dataset.tab);});
        }
    );
};

const switchTab = (tabIdentifier) => {
    console.log('switchTab', tabIdentifier);
    [...document.querySelectorAll('.tab')].forEach(
        (element) => {
            element.classList.remove('active');
        }
    );
    document.getElementById(tabIdentifier).classList.add('active');
};

const initSlider = () => {
    new Glide('#book-slider').mount();

    document.getElementById('center-button').addEventListener('click', () => {
        const offset = getOffsetElement(document.getElementById('book-slider'));
        window.scroll({
            top: offset.top,
            left: offset.left,
            behavior: 'smooth'
        });
    });
};

document.getElementById('book-tabs') && initBookTabs();
