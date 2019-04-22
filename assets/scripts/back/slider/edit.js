import axios from 'axios';
import Dropzone from 'dropzone';
import tableDragger from 'table-dragger'
import { displayModal, closeModal } from '../popup';

Dropzone.autoDiscover = false;

/**
 * Allows to initialize actions on slider list.
 */
const initActions = () => {
    const refreshPictureListUrl = document.getElementById('picture-wrapper').dataset.reloadUrl;
    const reorderPictureListUrl = document.getElementById('picture-list').dataset.reorderUrl;

    initUploadPicture(refreshPictureListUrl);
    initPictureReordering(reorderPictureListUrl);
    initPictureCrudActions(refreshPictureListUrl);
};

/**
 * Initializes DropZone to upload pictures.
 *
 * @param string refreshPictureListUrl
 */
const initUploadPicture = (refreshPictureListUrl) => {
    const pictureDropzone = new Dropzone('#picture-upload-form');
    pictureDropzone.on('queuecomplete', () => {
        reloadPictures(refreshPictureListUrl);
    });
};

/**
 * Allows to refresh pictures list for slider.
 *
 * @param string refreshPictureListUrl
 */
const reloadPictures = (refreshPictureListUrl) => {
    axios.get(refreshPictureListUrl)
        .then((response) => {
            document.getElementById('picture-wrapper').innerHTML = response.data;
            initPictureCrudActions(refreshPictureListUrl);
        })
    ;
};

/**
 * Allows to initialize drag and drop feature to reorder picture list.
 *
 * @param string reorderPictureListUrl
 */
const initPictureReordering = (reorderPictureListUrl) => {
    const dragger = tableDragger(document.getElementById('picture-list'), {
        mode: 'row',
    });

    dragger.on('drop', (from, to) => {
        const start = Math.min(from, to);
        const end = Math.max(from, to);
        reorderPictureRows(reorderPictureListUrl, start, end);
    });
};

/**
 * Allows to reorder pictures after drag and drop on list.
 * NOTE : new order is directly saved in BO using ajax call...
 *
 * @param reorderUrl URL to call to reorder pictures.
 * @param from Index of first row we are changing order (starting 1 for first row, not 0).
 * @param end Index of last row we are changing order.
 */
const reorderPictureRows = (reorderUrl, from, to) => {
    let reorderedIds = [];
    const rows = [...document.querySelectorAll('#picture-list tbody tr')];

    for (let i = from; i <= to; i++) {
        const row = rows[i - 1];
        reorderedIds.push({id: parseInt(row.getAttribute('data-id')), rank: i});
    }

    axios.post(reorderUrl, {reorderedIds: JSON.stringify(reorderedIds)})
        .then((response) => {
            if (!response.data.success) {
                displayModal(response.data.message);
            }
        })
    ;
};

/**
 * Initializes actions to edit/delete pictures.
 *
 * @param string refreshPictureListUrl
 */
const initPictureCrudActions = (refreshPictureListUrl) => {
    [...document.querySelectorAll('#picture-list span[data-edit-picture-url]')].forEach(
        (button) => {
            button.addEventListener('click', (event) => {
                editPicture(button.dataset.editPictureUrl);
            });
        }
    );

    [...document.querySelectorAll('#picture-list span[data-delete-picture-url]')].forEach(
        (button) => {
            button.addEventListener('click', (event) => {
                deletePicture(
                    button.dataset.deletePictureUrl,
                    refreshPictureListUrl,
                    button.dataset.confirmMessage
                );
            });
        }
    );
};

/**
 * Allows to edit quiz response.
 *
 * @param string editUrl
 */
const editPicture = (editUrl) => {
    axios.get(editUrl)
        .then(response => {
            displayModal(response.data);
        })
    ;
};

/**
 * Allows to remove quiz response.
 *
 * @param string deleteUrl
 * @param string refreshUrl
 * @param string confirmMessage
 */
const deletePicture = (deleteUrl, refreshUrl, confirmMessage) => {
    if (confirm(confirmMessage)) {
        axios.get(deleteUrl)
            .then(response => reloadPictures(refreshUrl))
        ;
    }
};

document.getElementById('picture-upload-form') && initActions();
