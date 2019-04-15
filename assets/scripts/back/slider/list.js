import { displayModal } from '../popup';

/**
 * Allows to initialize actions on slider list.
 */
const initActions = () => {
    document.getElementById('new-slider-button').addEventListener('click', (event) => {
        displayModal(document.getElementById('new-slider-form'));
    });

    initNewSliderFormBehavior();
};

/**
 * Allows to define behavior for new slider form.
 */
const initNewSliderFormBehavior = () => {
    const newSliderForm = document.getElementById('new-slider-form');

    newSliderForm.querySelector('input[type=text]').addEventListener('keyup', (event) => {
        const name = event.target.value;
        if (name.length > 2) {
            newSliderForm.querySelector('input[type=submit]').disabled = false;
            if ('Enter' === event.key || 13 === event.keyCode) {
                newSliderForm.submit();
            }
        } else {
            newSliderForm.querySelector('input[type=submit]').disabled = true;
        }
    });
};

document.getElementById('new-slider-form') && initActions();
