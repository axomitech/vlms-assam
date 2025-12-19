document.addEventListener('DOMContentLoaded', function () {

    const letterCards = Array.from(document.querySelectorAll('.letter-card'));
    const paginationContainer = document.getElementById('paginationContainer');
    const pageSizeDropdown = document.getElementById('pageSizeDropdown');
    const searchInput = document.querySelector('.search-bar input[type="text"]');
    let itemsPerPage = parseInt(pageSizeDropdown.value);

    function showPage(pageNumber) {
        const start = (pageNumber - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        letterCards.forEach((card, index) => {
            card.style.display = index >= start && index < end ? 'flex' : 'none';
        });
    }

    function createPageItem(page, currentPage, label = null, disabled = false) {
        const li = document.createElement('li');
        li.className = 'page-item' +
            (page === currentPage ? ' active' : '') +
            (disabled ? ' disabled' : '');

        const a = document.createElement('a');
        a.className = 'page-link';
        a.href = '#';
        a.innerText = label || page;

        if (!disabled) {
            a.addEventListener('click', function (e) {
                e.preventDefault();
                renderPagination(page);
            });
        }

        li.appendChild(a);
        return li;
    }

    function renderPagination(currentPage = 1) {
        itemsPerPage = parseInt(pageSizeDropdown.value);
        const totalPages = Math.ceil(letterCards.length / itemsPerPage);
        paginationContainer.innerHTML = '';

        paginationContainer.appendChild(
            createPageItem(currentPage - 1, currentPage, 'Previous', currentPage === 1)
        );

        for (let i = 1; i <= totalPages; i++) {
            paginationContainer.appendChild(createPageItem(i, currentPage));
        }

        paginationContainer.appendChild(
            createPageItem(currentPage + 1, currentPage, 'Next', currentPage === totalPages)
        );

        showPage(currentPage);
    }

    renderPagination();

    pageSizeDropdown.addEventListener('change', () => renderPagination(1));

    searchInput.addEventListener('input', function () {
        const q = this.value.toLowerCase();
        letterCards.forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(q) ? 'flex' : 'none';
        });
    });

    document.getElementById('resetView').addEventListener('click', function () {
        window.location.href = dashboardUrl;
    });
});
