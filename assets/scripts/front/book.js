import Glide from '@glidejs/glide'

const initBookTabs = () => {
    initTabActions();
    document.getElementById('book-slider') && initSlider();
}

const initTabActions = () => {
    [...document.querySelectorAll('#book-tabs [data-tab]')].forEach(
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
    new Glide('#book-slider').mount()
};

document.getElementById('book-tabs') && initBookTabs();
