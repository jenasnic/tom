import axios from 'axios';
import tableDragger from 'table-dragger'

/**
 * Allows to initialize drag and drop feature to reorder book list.
 */
const initBooksReordering = () => {
    const dragger = tableDragger(document.getElementById('book-list'), {
        mode: 'row',
        onlyBody: true,
    });

    const reorderUrl = document.getElementById('book-list').dataset.reorderUrl;
    dragger.on('drop', (from, to) => {
        const start = Math.min(from, to);
        const end = Math.max(from, to);
        reorderQuizRows(reorderUrl, start, end);
    });
};

/**
 * Allows to reorder books after drag and drop on list.
 * NOTE : new order is directly saved in BO using ajax call...
 *
 * @param reorderUrl URL to call to reorder books.
 * @param from Index of first row we are changing order (starting 1 for first row, not 0).
 * @param end Index of last row we are changing order.
 */
const reorderQuizRows = (reorderUrl, from, to) => {
    let reorderedIds = [];
    const rows = [...document.querySelectorAll('#book-list tbody tr')];

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

document.getElementById('book-list') && initBooksReordering();
