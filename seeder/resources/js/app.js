const input = document.querySelector('#bookSearch');
const rows = [...document.querySelectorAll('.book-row')];
const empty = document.querySelector('#emptyState');
const clear = document.querySelector('#clearSearch');

function filterBooks() {
    const term = (input?.value || '').trim().toLowerCase();
    let visible = 0;
    rows.forEach((row) => {
        const match = !term || row.dataset.search.includes(term);
        row.hidden = !match;
        if (match) visible++;
    });
    if (empty) empty.hidden = visible !== 0;
}

input?.addEventListener('input', filterBooks);
clear?.addEventListener('click', () => {
    if (input) input.value = '';
    filterBooks();
    document.querySelector('#acervo')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
});

document.addEventListener('keydown', (event) => {
    if ((event.metaKey || event.ctrlKey) && event.key.toLowerCase() === 'k') {
        event.preventDefault();
        input?.focus();
    }
});
